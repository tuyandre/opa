<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentAttendant extends Model
{
    protected $fillable = [
        'assessment_id', 'name', 'email', 'company', 'access_code', 'invited_at', 'status',
        'answers', 'started_at', 'submitted_at', 'score', 'total_marks',
        'percentage', 'passed', 'module_scores', 'auto_submit_reason',
    ];

    protected $casts = [
        'answers' => 'array',
        'module_scores' => 'array',
        'invited_at' => 'datetime',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'passed' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'Submitted';
    }

    // True when the attempt was closed automatically because the attendant left the assessment page.
    public function wasAutoSubmitted(): bool
    {
        return $this->isSubmitted() && $this->auto_submit_reason !== null;
    }

    public static function generateCode(): string
    {
        do {
            // No 0/O/1/I so codes survive being read out or retyped.
            $code = 'OPA-' . substr(str_shuffle(str_repeat('ABCDEFGHJKLMNPQRSTUVWXYZ23456789', 6)), 0, 6);
        } while (static::where('access_code', $code)->exists());
        return $code;
    }

    public function resultLabel(): string
    {
        if (!$this->isSubmitted()) {
            return $this->status;
        }
        return $this->passed ? 'Pass' : 'Fail';
    }

    // Grades the answers against the assessment's current questions and finalises the attempt.
    public function submit(array $answers, ?string $autoReason = null): void
    {
        $assessment = $this->assessment()->with('modules.questions')->first();
        $moduleScores = [];
        $score = 0.0;
        $total = 0.0;

        foreach ($assessment->modules as $module) {
            $moduleScore = 0.0;
            $moduleTotal = 0.0;
            $correct = 0;
            foreach ($module->questions as $question) {
                $marks = $assessment->marksFor($question);
                $moduleTotal += $marks;
                if ($question->isCorrect($answers[$question->id] ?? null)) {
                    $moduleScore += $marks;
                    $correct++;
                }
            }
            $moduleScores[] = [
                'module_id' => $module->id,
                'title' => $module->title,
                'score' => $moduleScore,
                'total' => $moduleTotal,
                'correct' => $correct,
                'questions' => $module->questions->count(),
            ];
            $score += $moduleScore;
            $total += $moduleTotal;
        }

        $percentage = $total > 0 ? round($score / $total * 100, 2) : 0;

        $this->forceFill([
            'answers' => $answers,
            'status' => 'Submitted',
            'submitted_at' => now(),
            'auto_submit_reason' => $autoReason,
            'score' => $score,
            'total_marks' => $total,
            'percentage' => $percentage,
            'passed' => $percentage >= $assessment->pass_mark,
            'module_scores' => $moduleScores,
        ])->save();
    }

    // Wipes the attempt so the same code can be used again.
    public function resetAttempt(): void
    {
        $this->forceFill([
            'status' => 'Not started', 'answers' => null, 'started_at' => null,
            'submitted_at' => null, 'auto_submit_reason' => null, 'score' => null, 'total_marks' => null,
            'percentage' => null, 'passed' => null, 'module_scores' => null,
        ])->save();
    }
}
