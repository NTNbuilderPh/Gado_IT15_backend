<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Show enrollment page with available courses.
     */
    public function index()
    {
        $student = Auth::user();

        $availableCourses = Course::open()
            ->forSemester($student->semester, $student->academic_year)
            ->orderBy('course_code')
            ->get();

        $enrolledCourseIds = $student->activeCourses()->pluck('courses.id')->toArray();

        return view('enrollment.index', compact('availableCourses', 'enrolledCourseIds', 'student'));
    }

    /**
     * Enroll student in a course.
     * Business Rules:
     *   1. Capacity Control  – block if students_count >= capacity
     *   2. Duplicate Prevention – block if already enrolled
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Auth::user();
        $courseId = $request->course_id;

        // Use DB transaction for data integrity
        return DB::transaction(function () use ($student, $courseId) {

            // Lock the course row to prevent race conditions
            $course = Course::lockForUpdate()->findOrFail($courseId);

            // RULE 1: Duplicate Prevention
            if ($student->isEnrolledIn($courseId)) {
                return back()->withErrors([
                    'enrollment' => "You are already enrolled in {$course->course_code} - {$course->course_name}.",
                ]);
            }

            // RULE 2: Capacity Control
            if ($course->students_count >= $course->capacity) {
                return back()->withErrors([
                    'enrollment' => "{$course->course_code} is already full ({$course->capacity}/{$course->capacity} students).",
                ]);
            }

            // RULE 3: Course must be open
            if ($course->status !== 'open') {
                return back()->withErrors([
                    'enrollment' => "{$course->course_code} is not open for enrollment.",
                ]);
            }

            // All rules passed — enroll the student
            $student->courses()->attach($courseId, [
                'enrolled_at'           => now(),
                'grade'                 => null,
                'attendance_percentage' => 100.00,
                'status'                => 'enrolled',
            ]);

            // Increment the denormalised counter
            $course->increment('students_count');

            return back()->with(
                'success',
                "Successfully enrolled in {$course->course_code} - {$course->course_name}!"
            );
        });
    }

    /**
     * Drop a course.
     */
    public function destroy(Course $course)
    {
        $student = Auth::user();

        if (!$student->isEnrolledIn($course->id)) {
            return back()->withErrors([
                'enrollment' => 'You are not enrolled in this course.',
            ]);
        }

        DB::transaction(function () use ($student, $course) {
            // Update pivot status to "dropped"
            $student->courses()->updateExistingPivot($course->id, [
                'status' => 'dropped',
            ]);

            // Decrement counter
            $course->decrement('students_count');
        });

        return back()->with(
            'success',
            "You have dropped {$course->course_code} - {$course->course_name}."
        );
    }
}