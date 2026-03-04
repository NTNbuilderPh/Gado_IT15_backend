<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'units',
        'schedule',
        'instructor',
        'room',
        'capacity',
        'students_count',
        'semester',
        'academic_year',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'units'          => 'integer',
            'capacity'       => 'integer',
            'students_count' => 'integer',
        ];
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student')
            ->withPivot(['grade', 'attendance_percentage', 'status', 'enrolled_at'])
            ->withTimestamps();
    }

    public function enrolledStudents()
    {
        return $this->students()->wherePivot('status', 'enrolled');
    }

    public function getIsFullAttribute(): bool
    {
        return $this->students_count >= $this->capacity;
    }

    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->capacity - $this->students_count);
    }

    public function getCapacityPercentageAttribute(): float
    {
        return $this->capacity > 0
            ? round(($this->students_count / $this->capacity) * 100, 1)
            : 0;
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'open')
            ->whereColumn('students_count', '<', 'capacity');
    }

    public function scopeForSemester($query, string $semester, string $academicYear)
    {
        return $query->where('semester', $semester)
            ->where('academic_year', $academicYear);
    }
}