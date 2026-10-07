<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentAttendant;
use App\Support\AssessmentCertificate;
use Illuminate\Http\Request;

class PublicAssessmentController extends Controller
{
    private const SESSION_KEY = 'assessment_attendant_id';

    // Landing page with the "name / email / personal code" form.
    public function landing($slug = null)
    {
        $assessment = $slug
            ? Assessment::with('modules.questions')->where('slug', $slug)->firstOrFail()
            : Assessment::with('modules.questions')->where('status', 'Active')->latest()->first();

        return view('frontend.assessment.landing', compact('assessment', 'slug'));
    }

    // Starts a new attempt, or resumes a draft / shows the score for a submitted one.
    public function start(Request $request, $slug = null)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'access_code' => 'required|string|max:50',
        ]);

        $attendant = AssessmentAttendant::with('assessment')
            ->where('access_code', strtoupper(trim($data['access_code'])))
            ->when($slug, fn($q) => $q->whereHas('assessment', fn($a) => $a->where('slug', $slug)))
            ->first();

        // One message for both cases so the form can't be used to probe which codes exist.
        $mismatch = !$attendant
            || ($attendant->email && strcasecmp(trim($attendant->email), trim($data['email'])) !== 0);
        if ($mismatch) {
            return back()->withInput($request->only('name', 'email', 'access_code'))
                ->withErrors(['access_code' => 'We could not match that code to your email. Check both and try again.']);
        }

        if (!$attendant->isSubmitted() && !$attendant->assessment->isOpen()) {
            return back()->withInput($request->only('name', 'email', 'access_code'))
                ->withErrors(['access_code' => 'This assessment is not open right now. Please contact your trainer.']);
        }

        // The attendant must acknowledge the "stay on this page" rule before starting or resuming.
        if (!$attendant->isSubmitted() && !$request->boolean('agree')) {
            return back()->withInput($request->only('name', 'email', 'access_code'))
                ->withErrors(['agree' => 'Please confirm you have read the rules before you start.']);
        }

        if (!$attendant->isSubmitted()) {
            $attendant->forceFill([
                'name' => $data['name'],
                'email' => $attendant->email ?: $data['email'],
                'status' => 'In progress',
                'started_at' => $attendant->started_at ?: now(),
            ])->save();
        }

        $request->session()->put(self::SESSION_KEY, $attendant->id);

        return redirect()->route($attendant->isSubmitted() ? 'assessment.result' : 'assessment.take');
    }

    public function take(Request $request)
    {
        $attendant = $this->currentAttendant($request);
        if (!$attendant) {
            return redirect()->route('assessment.landing');
        }
        if ($attendant->isSubmitted()) {
            return redirect()->route('assessment.result');
        }

        $assessment = $attendant->assessment->load('modules.questions');

        return view('frontend.assessment.take', compact('attendant', 'assessment'));
    }

    // Autosave of the in-progress answers (called from the page every few seconds).
    public function save(Request $request)
    {
        $attendant = $this->currentAttendant($request);
        if (!$attendant || $attendant->isSubmitted()) {
            return response()->json(['saved' => false], 409);
        }

        $attendant->update(['answers' => $this->cleanAnswers($request)]);

        return response()->json(['saved' => true]);
    }

    public function submit(Request $request)
    {
        $attendant = $this->currentAttendant($request);
        if (!$attendant) {
            return redirect()->route('assessment.landing');
        }
        if (!$attendant->isSubmitted()) {
            // 'left_page' is sent by the assessment page when the attendant switched tab/window.
            $reason = $request->input('auto') === 'left_page' ? 'left_page' : null;
            $attendant->submit($this->cleanAnswers($request), $reason);
        }

        return redirect()->route('assessment.result');
    }

    public function result(Request $request)
    {
        $attendant = $this->currentAttendant($request);
        if (!$attendant) {
            return redirect()->route('assessment.landing');
        }
        if (!$attendant->isSubmitted()) {
            return redirect()->route('assessment.take');
        }

        $assessment = $attendant->assessment;

        return view('frontend.assessment.result', compact('attendant', 'assessment'));
    }

    // Attendants download their own certificate once they have passed.
    public function certificate(Request $request)
    {
        $attendant = $this->currentAttendant($request);
        if (!$attendant || !AssessmentCertificate::canIssue($attendant)) {
            return redirect()->route($attendant ? 'assessment.result' : 'assessment.landing');
        }

        return AssessmentCertificate::make($attendant)->download(AssessmentCertificate::fileName($attendant));
    }

    private function currentAttendant(Request $request): ?AssessmentAttendant
    {
        $id = $request->session()->get(self::SESSION_KEY);

        return $id ? AssessmentAttendant::with('assessment')->find($id) : null;
    }

    // Keeps only answers for this assessment's questions, as trimmed strings.
    private function cleanAnswers(Request $request): array
    {
        $attendant = $this->currentAttendant($request);
        $valid = $attendant->assessment->questions()->pluck('id')->all();
        $clean = [];
        foreach ((array) $request->input('answers', []) as $questionId => $value) {
            if (in_array((int) $questionId, $valid, true) && is_scalar($value) && trim((string) $value) !== '') {
                $clean[(int) $questionId] = mb_substr(trim((string) $value), 0, 100);
            }
        }

        return $clean;
    }
}
