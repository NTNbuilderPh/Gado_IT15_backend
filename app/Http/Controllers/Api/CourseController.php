<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * GET /api/courses
     */
    public function index(Request $request)
    {
        $query = Course::open();

        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%")
                  ->orWhere('instructor', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('course_code')->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => $courses,
        ]);
    }

    /**
     * GET /api/courses/{id}
     */
    public function show(Course $course)
    {
        $course->load(['enrolledStudents' => function ($q) {
            $q->select('students.id', 'student_number', 'first_name', 'last_name');
        }]);

        return response()->json([
            'success' => true,
            'data'    => $course,
        ]);
    }
}