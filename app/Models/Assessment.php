<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'version', 'description', 'client_id', 'training_session_id',
        'pass_mark', 'marks_per_question', 'suggested_minutes', 'status', 'certificate_title', 'certificate_text', 'certificate_subject', 'created_by',
    ];

    public const DEFAULT_CERTIFICATE_TEXT = 'for passing the final assessment';

    // Line printed under the attendant's name.
    public function certificateText(): string
    {
        return trim((string) $this->certificate_text) !== '' ? trim($this->certificate_text) : self::DEFAULT_CERTIFICATE_TEXT;
    }

    // Bold line printed under that: defaults to the assessment title.
    public function certificateSubject(): string
    {
        return trim((string) $this->certificate_subject) !== '' ? trim($this->certificate_subject) : $this->title;
    }

    public const DEFAULT_CERTIFICATE_TITLE = 'Certificate of Completion';

    public function certificateTitle(): string
    {
        return trim((string) $this->certificate_title) !== '' ? trim($this->certificate_title) : self::DEFAULT_CERTIFICATE_TITLE;
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title) . '-' . Str::lower(Str::random(6));
            }
        });
    }

    public function modules(): HasMany
    {
        return $this->hasMany(AssessmentModule::class)->orderBy('position')->orderBy('id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class)->orderBy('position')->orderBy('id');
    }

    public function attendants(): HasMany
    {
        return $this->hasMany(AssessmentAttendant::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class, 'training_session_id');
    }

    public function isOpen(): bool
    {
        return $this->status === 'Active';
    }

    public function marksFor(AssessmentQuestion $question): float
    {
        return (float) ($question->marks ?? $this->marks_per_question);
    }

    public function totalMarks(): float
    {
        return (float) $this->questions->sum(fn($q) => $this->marksFor($q));
    }

    public function publicUrl(): string
    {
        return route('assessment.landing', $this->slug);
    }
}
