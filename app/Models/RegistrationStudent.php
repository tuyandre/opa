<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
