<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RegistrationStudent extends Model
{
    use HasFactory;

    public function services():belongsToMany
    {
        return $this->belongsToMany(TrainingService::class, 'student_services', 'registration_student_id', 'training_service_id');
    }

    public function session():belongsTo
    {
        return $this->belongsTo(TrainingSession::class, 'training_session_id');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(StudentMaterial::class, 'student_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(StudentMaterial::class, 'student_id')->where('type', 'certificate');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'student_id');
    }
}
