<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSession extends Model
{
    use HasFactory;

    public function students():hasMany
    {
        return $this->hasMany(RegistrationStudent::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    // The earliest Active session that still has open slots, or null if none.
    public static function nextOpenForRegistration(): ?self
    {
        return static::where('status', 'Active')
            ->withCount('students')
            ->orderBy('start_date')
            ->get()
            ->first(fn($session) => $session->students_count < $session->maximum_students);
    }
}
