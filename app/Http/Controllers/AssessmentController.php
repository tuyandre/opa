<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentAttendant;
use App\Models\AssessmentModule;
use App\Models\AssessmentQuestion;
use App\Models\Client;
use App\Models\TrainingSession;
use App\Support\AssessmentCertificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::withCount(['modules', 'questions', 'attendants'])
            ->with('client')
            ->latest()
            ->get();
        $clients = Client::orderBy('name')->get();
        $sessions = TrainingSession::orderByDesc('id')->get();

        return view('backend.assessments.index', compact('assessments', 'clients', 'sessions'));
    }

    public function store(Request $request)
    {
        $assessment = new Assessment($this->validateAssessment($request));
        $assessment->created_by = auth()->id();
        $assessment->save();

        return redirect()->route('admin.assessments.show', $assessment->id)
            ->with('success', 'Assessment created. Add modules and questions next.');
    }

    public function update(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->update($this->validateAssessment($request));

        return redirect()->back()->with('success', 'Assessment updated.');
    }

    public function destroy($id)
    {
        Assessment::findOrFail($id)->delete();

        return redirect()->route('admin.assessments.index')->with('success', 'Assessment deleted.');
    }

    public function show($id)
    {
        $assessment = Assessment::with(['modules.questions', 'attendants' => fn($q) => $q->orderBy('name'), 'client', 'session'])
            ->findOrFail($id);
        $clients = Client::orderBy('name')->get();
        $sessions = TrainingSession::orderByDesc('id')->get();
        $stats = $this->stats($assessment);

        return view('backend.assessments.show', compact('assessment', 'clients', 'sessions', 'stats'));
    }

    // ---- Modules ----------------------------------------------------------

    public function storeModule(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $data = $request->validate(['title' => 'required|string|max:255']);

        $assessment->modules()->create([
            'title' => $data['title'],
            'position' => (int) $assessment->modules()->max('position') + 1,
        ]);

        return redirect()->back()->with('tab', 'questions')->with('success', 'Module added.');
    }

    public function updateModule(Request $request, $id)
    {
        $module = AssessmentModule::findOrFail($id);
        $module->update($request->validate(['title' => 'required|string|max:255']));

        return redirect()->back()->with('tab', 'questions')->with('success', 'Module updated.');
    }

    public function destroyModule($id)
    {
        AssessmentModule::findOrFail($id)->delete();

        return redirect()->back()->with('tab', 'questions')->with('success', 'Module and its questions deleted.');
    }

    // ---- Questions --------------------------------------------------------

    public function storeQuestion(Request $request, $moduleId)
    {
        $module = AssessmentModule::findOrFail($moduleId);
        $data = $this->validateQuestion($request);
        $data['assessment_id'] = $module->assessment_id;
        $data['position'] = (int) $module->questions()->max('position') + 1;

        $module->questions()->create($data);

        return redirect()->back()->with('tab', 'questions')->with('success', 'Question added.');
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = AssessmentQuestion::findOrFail($id);
        $question->update($this->validateQuestion($request));

        return redirect()->back()->with('tab', 'questions')->with('success', 'Question updated.');
    }

    public function destroyQuestion($id)
    {
        AssessmentQuestion::findOrFail($id)->delete();

        return redirect()->back()->with('tab', 'questions')->with('success', 'Question deleted.');
    }

    // ---- Attendants -------------------------------------------------------

    public function storeAttendant(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
        ]);

        $attendant = $assessment->attendants()->create($data + ['access_code' => AssessmentAttendant::generateCode()]);

        return redirect()->back()->with('success', "Attendant added. Access code: {$attendant->access_code}");
    }

    // One attendant per line: "Name, email, company" (email and company optional).
    public function bulkAttendants(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $request->validate(['list' => 'required|string']);

        $created = 0;
        foreach (preg_split('/\r\n|\r|\n/', $request->list) as $line) {
            $parts = array_map('trim', str_getcsv($line));
            if (($parts[0] ?? '') === '') {
                continue;
            }
            $email = $parts[1] ?? null;
            $assessment->attendants()->create([
                'name' => Str::limit($parts[0], 255, ''),
                'email' => $email && filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null,
                'company' => ($parts[2] ?? null) ?: null,
                'access_code' => AssessmentAttendant::generateCode(),
            ]);
            $created++;
        }

        return redirect()->back()->with('success', "$created attendant(s) added with personal access codes.");
    }

    public function destroyAttendant($id)
    {
        AssessmentAttendant::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Attendant removed.');
    }

    public function resetAttendant($id)
    {
        AssessmentAttendant::findOrFail($id)->resetAttempt();

        return redirect()->back()->with('success', 'Attempt reset. The attendant can start again with the same code.');
    }

    public function attendantResult($id)
    {
        $attendant = AssessmentAttendant::with('assessment.modules.questions')->findOrFail($id);

        return view('backend.assessments.attendant', ['attendant' => $attendant, 'assessment' => $attendant->assessment]);
    }

    // ---- Reports ----------------------------------------------------------

    public function reportPdf($id)
    {
        $assessment = Assessment::with(['modules.questions', 'attendants' => fn($q) => $q->orderByDesc('percentage'), 'client'])
            ->findOrFail($id);
        $stats = $this->stats($assessment);

        return Pdf::loadView('pdf.assessment_report', compact('assessment', 'stats'))
            ->setPaper('a4')
            ->download($this->fileName($assessment->title . ' Report', 'pdf'));
    }

    public function attendantPdf($id)
    {
        $attendant = AssessmentAttendant::with('assessment.modules.questions')->findOrFail($id);
        abort_unless($attendant->isSubmitted(), 404);

        return Pdf::loadView('pdf.assessment_result', ['attendant' => $attendant, 'assessment' => $attendant->assessment])
            ->setPaper('a4')
            ->download($this->fileName($attendant->assessment->title . ' ' . $attendant->name, 'pdf'));
    }

    // Certificate of completion for one attendant who passed.
    public function certificate($id)
    {
        $attendant = AssessmentAttendant::with('assessment')->findOrFail($id);
        if (!AssessmentCertificate::canIssue($attendant)) {
            return redirect()->back()->with('error', 'A certificate can only be issued to an attendant who has passed.');
        }

        return AssessmentCertificate::make($attendant)->download(AssessmentCertificate::fileName($attendant));
    }

    // One ZIP with a certificate for every attendant who passed.
    public function certificatesZip($id)
    {
        $assessment = Assessment::findOrFail($id);
        $passed = $assessment->attendants()->where('status', 'Submitted')->where('passed', true)->orderBy('name')->get();
        if ($passed->isEmpty()) {
            return redirect()->back()->with('tab', 'attendants')->with('error', 'No one has passed yet, so there are no certificates to generate.');
        }

        set_time_limit(0);
        $zipPath = tempnam(sys_get_temp_dir(), 'certs');
        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::OVERWRITE);
        $used = [];
        foreach ($passed as $attendant) {
            $attendant->setRelation('assessment', $assessment);
            $name = AssessmentCertificate::fileName($attendant);
            if (isset($used[$name])) { // two people with the same name
                $name = str_replace('.pdf', ' ' . $attendant->id . '.pdf', $name);
            }
            $used[$name] = true;
            $zip->addFromString($name, AssessmentCertificate::make($attendant)->output());
        }
        $zip->close();

        return response()->download($zipPath, $this->fileName($assessment->title . ' Certificates', 'zip'))->deleteFileAfterSend(true);
    }

    public function exportCsv($id)
    {
        $assessment = Assessment::with(['modules', 'attendants' => fn($q) => $q->orderBy('name')])->findOrFail($id);

        return response()->streamDownload(function () use ($assessment) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel reads accents correctly
            $header = ['Name', 'Email', 'Company', 'Access code', 'Status', 'Score', 'Total marks', 'Percentage', 'Result', 'Submitted at'];
            foreach ($assessment->modules as $module) {
                $header[] = $module->title;
            }
            fputcsv($out, $header);

            foreach ($assessment->attendants as $a) {
                $row = [
                    $a->name, $a->email, $a->company, $a->access_code, $a->status,
                    $a->score, $a->total_marks, $a->percentage,
                    $a->isSubmitted() ? $a->resultLabel() : '',
                    optional($a->submitted_at)->format('Y-m-d H:i'),
                ];
                $byModule = collect($a->module_scores ?? [])->keyBy('module_id');
                foreach ($assessment->modules as $module) {
                    $m = $byModule->get($module->id);
                    $row[] = $m ? ($m['score'] . '/' . $m['total']) : '';
                }
                fputcsv($out, $row);
            }
            fclose($out);
        }, $this->fileName($assessment->title . ' Results', 'csv'), ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // ---- Helpers ----------------------------------------------------------

    // Summary used by the results tab and the PDF report.
    private function stats(Assessment $assessment): array
    {
        $attendants = $assessment->attendants;
        $submitted = $attendants->where('status', 'Submitted');
        $count = $submitted->count();

        $modules = [];
        foreach ($assessment->modules as $module) {
            $scores = $submitted->map(fn($a) => collect($a->module_scores ?? [])->firstWhere('module_id', $module->id))->filter();
            $total = $scores->sum('total');
            $modules[] = [
                'title' => $module->title,
                'average_pct' => $total > 0 ? round($scores->sum('score') / $total * 100, 1) : null,
            ];
        }

        // Share of submitted attendants who got each question right, to spot weak topics.
        $questionRates = [];
        foreach ($assessment->modules as $module) {
            foreach ($module->questions as $question) {
                $right = $submitted->filter(fn($a) => $question->isCorrect(($a->answers ?? [])[$question->id] ?? null))->count();
                $questionRates[$question->id] = $count > 0 ? round($right / $count * 100) : null;
            }
        }

        return [
            'invited' => $attendants->count(),
            'started' => $attendants->whereIn('status', ['In progress', 'Submitted'])->count(),
            'submitted' => $count,
            'passed' => $submitted->where('passed', true)->count(),
            'failed' => $submitted->where('passed', false)->count(),
            'pass_rate' => $count > 0 ? round($submitted->where('passed', true)->count() / $count * 100) : null,
            'average' => $count > 0 ? round($submitted->avg('percentage'), 1) : null,
            'highest' => $count > 0 ? (float) $submitted->max('percentage') : null,
            'lowest' => $count > 0 ? (float) $submitted->min('percentage') : null,
            'modules' => $modules,
            'question_rates' => $questionRates,
        ];
    }

    private function validateAssessment(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'version' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
            'training_session_id' => 'nullable|exists:training_sessions,id',
            'pass_mark' => 'required|integer|min:1|max:100',
            'marks_per_question' => 'required|numeric|min:0.01|max:1000',
            'suggested_minutes' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:Draft,Active,Closed',
            'certificate_title' => 'nullable|string|max:80',
            'certificate_text' => 'nullable|string|max:120',
            'certificate_subject' => 'nullable|string|max:150',
        ]);
    }

    private function validateQuestion(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:choice,number',
            'body' => 'required|string',
            'marks' => 'nullable|numeric|min:0.01|max:1000',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string|max:1000',
            'correct_choice' => 'nullable|string|max:1',
            'correct_number' => 'nullable|string|max:50',
            'tolerance' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:30',
        ]);

        if ($data['type'] === 'choice') {
            $options = collect($data['options'] ?? [])
                ->map(fn($text) => trim((string) $text))
                ->filter(fn($text) => $text !== '')
                ->all();
            if (count($options) < 2) {
                throw ValidationException::withMessages(['options' => 'A multiple-choice question needs at least two options.']);
            }
            $correct = strtoupper($data['correct_choice'] ?? '');
            if (!array_key_exists($correct, $options)) {
                throw ValidationException::withMessages(['correct_choice' => 'Pick the correct option from the filled-in options.']);
            }

            return [
                'type' => 'choice', 'body' => $data['body'], 'marks' => $data['marks'] ?? null,
                'options' => $options, 'correct_answer' => $correct, 'unit' => null,
            ];
        }

        if (AssessmentQuestion::parseNumber($data['correct_number'] ?? '') === null) {
            throw ValidationException::withMessages(['correct_number' => 'Enter the correct answer as a number.']);
        }

        return [
            'type' => 'number', 'body' => $data['body'], 'marks' => $data['marks'] ?? null,
            'options' => null, 'correct_answer' => (string) AssessmentQuestion::parseNumber($data['correct_number']),
            'tolerance' => $data['tolerance'] ?? 0.01, 'unit' => $data['unit'] ?? null,
        ];
    }

    // House file naming standard: "YYMMDD Title.ext"
    private function fileName(string $title, string $extension): string
    {
        $clean = trim(preg_replace('/[\\\\\/:*?"<>|]+/', ' ', $title));

        return date('ymd') . ' ' . preg_replace('/\s+/', ' ', $clean) . '.' . $extension;
    }
}
