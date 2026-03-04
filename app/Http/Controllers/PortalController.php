<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    /**
     * Real-time grade tracking.
     */
    public function grades()
    {
        $student = Auth::user();
        $courses = $student->courses()
            ->orderBy('course_code')
            ->get();

        $gpa = $student->gpa;

        return view('portal.grades', compact('student', 'courses', 'gpa'));
    }

    /**
     * Real-time attendance tracking.
     */
    public function attendance()
    {
        $student = Auth::user();
        $courses = $student->activeCourses()
            ->orderBy('course_code')
            ->get();

        $averageAttendance = $courses->avg('pivot.attendance_percentage') ?? 100;

        return view('portal.attendance', compact('student', 'courses', 'averageAttendance'));
    }
}