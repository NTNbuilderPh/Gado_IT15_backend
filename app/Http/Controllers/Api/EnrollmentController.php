<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * POST /api/enrollment — enroll in a course.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = $request->user();
        $courseId = $request->course_id;

        return DB::transaction(function () use ($student, $courseId) {

            $course = Course::lockForUpdate()->findOrFail($courseId);

            // Duplicate Prevention
            if ($student->isEnrolledIn($courseId)) {
                return response()->json([
                    'success' => false,
                    'message' => "Already enrolled in {$course->course_code}.",
                ], 409);
            }

            // Capacity Control
            if ($course->students_count >= $course->capacity) {
                return response()->json([
                    'success' => false,
                    'message' => "{$course->course_code} is full ({$course->capacity}/{$course->capacity}).",
                ], 422);
            }

            if ($course->status !== 'open') {
                return response()->json([
                    'success' => false,
                    'message' => "{$course->course_code} is not open for enrollment.",
                ], 422);
            }

            $student->courses()->attach($courseId, [
                'enrolled_at'           => now(),
                'attendance_percentage' => 100.00,
                'status'                => 'enrolled',
            ]);

            $course->increment('students_count');

            return response()->json([
                'success' => true,
                'message' => "Enrolled in {$course->course_code} - {$course->course_name}.",
                'data'    => [
                    'course'         => $course->fresh(),
                    'available_slots'=> $course->fresh()->available_slots,
                ],
            ], 201);
        });
    }

    /**
     * DELETE /api/enrollment/{course} — drop a course.
     */
    public function destroy(Request $request, Course $course)
    {
        $student = $request->user();

        if (!$student->isEnrolledIn($course->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Not enrolled in this course.',
            ], 404);
        }

        DB::transaction(function () use ($student, $course) {
            $student->courses()->updateExistingPivot($course->id, [
                'status' => 'dropped',
            ]);
            $course->decrement('students_count');
        });

        return response()->json([
            'success' => true,
            'message' => "Dropped {$course->course_code}.",
        ]);
    }

    /**
     * GET /api/grades
     */
    public function grades(Request $request)
    {
        $student = $request->user();
        $courses = $student->courses()->orderBy('course_code')->get();

        $gradesData = $courses->map(function ($course) {
            return [
                'course_code'  => $course->course_code,
                'course_name'  => $course->course_name,
                'units'        => $course->units,
                'grade'        => $course->pivot->grade,
                'status'       => $course->pivot->status,
                'instructor'   => $course->instructor,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'gpa'     => $student->gpa,
                'courses' => $gradesData,
            ],
        ]);
    }

    /**
     * GET /api/attendance
     */
    public function attendance(Request $request)
    {
        $student = $request->user();
        $courses = $student->activeCourses()->orderBy('course_code')->get();

        $attendanceData = $courses->map(function ($course) {
            return [
                'course_code'           => $course->course_code,
                'course_name'           => $course->course_name,
                'attendance_percentage' => $course->pivot->attendance_percentage,
                'schedule'              => $course->schedule,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'average_attendance' => $courses->avg('pivot.attendance_percentage') ?? 100,
                'courses'            => $attendanceData,
            ],
        ]);
    }
}