<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class StudentMaterial extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::lower(Str::random(16));
            }
        });
    }

    public function student()
    {
        return $this->belongsTo('App\Models\RegistrationStudent');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class, 'training_session_id');
    }

    public function scopeMaterials($query)
    {
        return $query->where('type', 'material');
    }

    public function scopeCertificates($query)
    {
        return $query->where('type', 'certificate');
    }
}
