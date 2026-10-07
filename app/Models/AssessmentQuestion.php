<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentQuestion extends Model
{
    protected $fillable = [
        'assessment_id', 'assessment_module_id', 'position', 'type', 'body',
        'options', 'correct_answer', 'tolerance', 'unit', 'marks',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(AssessmentModule::class, 'assessment_module_id');
    }

    public function isChoice(): bool
    {
        return $this->type === 'choice';
    }

    // Accepts "1,200,000", "RWF 1 200 000", "40%" and similar; null when not a number.
    public static function parseNumber($value): ?float
    {
        $clean = preg_replace('/[^0-9.\-]/', '', (string) $value);
        if ($clean === '' || !is_numeric($clean)) {
            return null;
        }
        return (float) $clean;
    }

    public function isCorrect($answer): bool
    {
        if ($answer === null || trim((string) $answer) === '') {
            return false;
        }

        if ($this->isChoice()) {
            return strtoupper(trim((string) $answer)) === strtoupper(trim($this->correct_answer));
        }

        $given = self::parseNumber($answer);
        $expected = self::parseNumber($this->correct_answer);
        if ($given === null || $expected === null) {
            return false;
        }
        return abs($given - $expected) <= (float) $this->tolerance + 1e-9;
    }

    // Human-readable correct answer for review screens and reports.
    public function correctLabel(): string
    {
        if ($this->isChoice()) {
            $key = strtoupper($this->correct_answer);
            return $key . '. ' . ($this->options[$key] ?? '');
        }
        $n = self::parseNumber($this->correct_answer);
        return ($n !== null ? rtrim(rtrim(number_format($n, 2), '0'), '.') : $this->correct_answer)
            . ($this->unit ? ' ' . $this->unit : '');
    }

    public function answerLabel($answer): string
    {
        if ($answer === null || trim((string) $answer) === '') {
            return '—';
        }
        if ($this->isChoice()) {
            $key = strtoupper(trim($answer));
            return $key . '. ' . ($this->options[$key] ?? '');
        }
        return (string) $answer;
    }
}
