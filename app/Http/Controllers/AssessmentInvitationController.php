<?php

namespace App\Http\Controllers;

use App\Mail\AssessmentInvitation;
use App\Models\Assessment;
use App\Models\AssessmentAttendant;
use App\Support\SimpleXlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

/**
 * Excel import of attendants (template -> upload -> preview -> confirm) and invitation emails.
 */
class AssessmentInvitationController extends Controller
{
    // The example row in the template; ignored on import so it never becomes an attendant.
    private const EXAMPLE_EMAIL = 'jane.uwase@example.com';

    public function template($id)
    {
        $assessment = Assessment::findOrFail($id);
        $path = SimpleXlsx::write([
            ['Full name', 'Email', 'Company'],
            ['Jane Uwase', self::EXAMPLE_EMAIL, 'Example Ltd'],
        ], 'Attendants', [30, 36, 28]);

        return response()->download($path, date('ymd') . ' ' . $this->safe($assessment->title) . ' Attendants Template.xlsx')
            ->deleteFileAfterSend(true);
    }

    // Reads the uploaded sheet and shows a preview. Nothing is saved until the user confirms.
    public function upload(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $request->validate(['file' => 'required|file|max:2048|mimes:xlsx,csv,txt']);

        $file = $request->file('file');
        try {
            $sheet = SimpleXlsx::read($file->getRealPath(), $file->getClientOriginalExtension());
        } catch (RuntimeException $e) {
            return redirect()->back()->with('tab', 'attendants')->with('error', $e->getMessage());
        }

        $rows = $this->parseRows($sheet, $assessment);
        if (empty($rows)) {
            return redirect()->back()->with('tab', 'attendants')
                ->with('error', 'No attendants found. Use the template: Full name, Email, Company, one person per row.');
        }

        $request->session()->put($this->sessionKey($id), $rows);

        return redirect()->route('admin.assessments.attendants.import.preview', $id);
    }

    public function preview(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $rows = $request->session()->get($this->sessionKey($id));
        if (!$rows) {
            return redirect()->route('admin.assessments.show', $id)->with('tab', 'attendants')
                ->with('error', 'Nothing to confirm. Upload your Excel file again.');
        }

        $valid = collect($rows)->where('problem', null)->count();

        return view('backend.assessments.import_preview', compact('assessment', 'rows', 'valid'));
    }

    public function confirm(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $rows = $request->session()->pull($this->sessionKey($id));
        if (!$rows) {
            return redirect()->route('admin.assessments.show', $id)->with('tab', 'attendants')
                ->with('error', 'This import has expired. Upload your Excel file again.');
        }

        $created = collect();
        foreach ($rows as $row) {
            if ($row['problem'] !== null) {
                continue;
            }
            // Re-check at confirm time in case someone was added since the preview.
            if ($assessment->attendants()->where('email', $row['email'])->exists()) {
                continue;
            }
            $created->push($assessment->attendants()->create([
                'name' => $row['name'], 'email' => $row['email'], 'company' => $row['company'] ?: null,
                'access_code' => AssessmentAttendant::generateCode(),
            ]));
        }

        $message = $created->count() . ' attendant(s) added with personal access codes.';
        if ($request->boolean('send_emails') && $created->isNotEmpty()) {
            [$sent, $failed] = $this->sendTo($created);
            $message .= " Invitation emails sent: $sent" . ($failed ? ", failed: $failed (use Send invitations to retry)" : '') . '.';
            if (!$assessment->isOpen()) {
                $message .= ' Note: the assessment is ' . $assessment->status . ', so the link will not let them start until you set it to Active.';
            }
        }

        return redirect()->route('admin.assessments.show', $id)->with('tab', 'attendants')->with('success', $message);
    }

    // mode=pending: only people never emailed. mode=all: everyone who has not submitted yet.
    public function send(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $mode = $request->input('mode') === 'all' ? 'all' : 'pending';

        $query = $assessment->attendants()->whereNotNull('email')->where('status', '!=', 'Submitted');
        if ($mode === 'pending') {
            $query->whereNull('invited_at');
        }
        $attendants = $query->get();

        if ($attendants->isEmpty()) {
            return redirect()->back()->with('tab', 'attendants')
                ->with('error', $mode === 'pending' ? 'Everyone with an email has already been invited.' : 'No attendants with an email to send to.');
        }

        [$sent, $failed] = $this->sendTo($attendants);
        $message = "Invitation emails sent: $sent" . ($failed ? ", failed: $failed" : '') . '.';
        if (!$assessment->isOpen()) {
            $message .= ' Note: the assessment is ' . $assessment->status . ', so attendants cannot start until you set it to Active.';
        }

        return redirect()->back()->with('tab', 'attendants')->with($failed ? 'error' : 'success', $message);
    }

    public function sendOne($id)
    {
        $attendant = AssessmentAttendant::with('assessment')->findOrFail($id);
        if (!$attendant->email) {
            return redirect()->back()->with('tab', 'attendants')->with('error', 'This attendant has no email address.');
        }

        [$sent] = $this->sendTo(collect([$attendant]));

        return redirect()->back()->with('tab', 'attendants')->with(
            $sent ? 'success' : 'error',
            $sent ? "Invitation sent to {$attendant->email}." : "Could not send to {$attendant->email}. Check the mail settings and try again."
        );
    }

    // ---- Helpers ----------------------------------------------------------

    /** @return array{0:int,1:int} [sent, failed] */
    private function sendTo($attendants): array
    {
        set_time_limit(0);
        $sent = 0;
        $failed = 0;
        foreach ($attendants as $attendant) {
            try {
                Mail::to($attendant->email)->send(new AssessmentInvitation($attendant->loadMissing('assessment')));
                $attendant->forceFill(['invited_at' => now()])->save();
                $sent++;
            } catch (\Throwable $e) {
                Log::warning('Assessment invitation failed for attendant ' . $attendant->id . ': ' . $e->getMessage());
                $failed++;
            }
        }

        return [$sent, $failed];
    }

    // Turns sheet rows into [name, email, company, problem|null]. Finds columns by header, else uses A/B/C.
    private function parseRows(array $sheet, Assessment $assessment): array
    {
        $map = ['name' => 0, 'email' => 1, 'company' => 2];
        $first = array_map(fn($v) => strtolower(trim((string) $v)), $sheet[0] ?? []);
        $hasHeader = in_array('email', $first, true) || in_array('full name', $first, true) || in_array('name', $first, true);
        if ($hasHeader) {
            foreach ($first as $i => $label) {
                if (in_array($label, ['full name', 'name', 'attendant', 'participant name'], true)) { $map['name'] = $i; }
                if (in_array($label, ['email', 'email address', 'e-mail'], true)) { $map['email'] = $i; }
                if (in_array($label, ['company', 'client', 'organisation', 'organization', 'client / company'], true)) { $map['company'] = $i; }
            }
            array_shift($sheet);
        }

        $existing = $assessment->attendants()->pluck('email')->filter()->map(fn($e) => strtolower($e))->all();
        $seen = [];
        $rows = [];
        foreach ($sheet as $line) {
            $name = trim($line[$map['name']] ?? '');
            $email = trim($line[$map['email']] ?? '');
            $company = trim($line[$map['company']] ?? '');
            if ($name === '' && $email === '' && $company === '') {
                continue;
            }
            if (strtolower($email) === self::EXAMPLE_EMAIL) {
                continue;
            }

            $problem = null;
            $key = strtolower($email);
            if ($name === '') {
                $problem = 'Name is missing';
            } elseif ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $problem = 'Email is missing or not valid';
            } elseif (in_array($key, $existing, true)) {
                $problem = 'Already an attendant of this assessment';
            } elseif (isset($seen[$key])) {
                $problem = 'Duplicate email in this file';
            }
            $seen[$key] = true;

            $rows[] = ['name' => mb_substr($name, 0, 255), 'email' => $email, 'company' => mb_substr($company, 0, 255), 'problem' => $problem];
        }

        return $rows;
    }

    private function sessionKey($id): string
    {
        return 'assessment_import_' . $id;
    }

    private function safe(string $title): string
    {
        return trim(preg_replace('/\s+/', ' ', preg_replace('/[\\\\\/:*?"<>|]+/', ' ', $title)));
    }
}
