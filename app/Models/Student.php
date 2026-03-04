<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'program',
        'year_level',
        'semester',
        'academic_year',
        'id_photo',
        'scholarship_balance',
        'tuition_balance',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'date_of_birth'        => 'date',
            'password'             => 'hashed',
            'scholarship_balance'  => 'decimal:2',
            'tuition_balance'      => 'decimal:2',
        ];
    }

    /* ─── Relationships ─── */

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
            ->withPivot(['grade', 'attendance_percentage', 'status', 'enrolled_at'])
            ->withTimestamps();
    }

    public function activeCourses()
    {
        return $this->courses()->wherePivot('status', 'enrolled');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /* ─── Accessors ─── */

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getTotalUnitsAttribute(): int
    {
        return $this->activeCourses->sum('units');
    }

    public function getGpaAttribute(): ?float
    {
        $graded = $this->courses()->wherePivotNotNull('grade')->get();

        if ($graded->isEmpty()) {
            return null;
        }

        $totalPoints = 0;
        $totalUnits  = 0;

        foreach ($graded as $course) {
            $totalPoints += $course->pivot->grade * $course->units;
            $totalUnits  += $course->units;
        }

        return $totalUnits > 0 ? round($totalPoints / $totalUnits, 2) : null;
    }

    /* ─── Helpers ─── */

    public function isEnrolledIn(int $courseId): bool
    {
        return $this->courses()
            ->where('courses.id', $courseId)
            ->wherePivot('status', 'enrolled')
            ->exists();
    }
}