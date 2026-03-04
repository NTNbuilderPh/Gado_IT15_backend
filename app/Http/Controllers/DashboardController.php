<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $student->load(['activeCourses', 'payments' => function ($q) {
            $q->latest()->limit(5);
        }]);

        $stats = [
            'enrolled_courses'  => $student->activeCourses->count(),
            'total_units'       => $student->activeCourses->sum('units'),
            'gpa'               => $student->gpa,
            'tuition_balance'   => $student->tuition_balance,
            'scholarship'       => $student->scholarship_balance,
            'attendance_avg'    => $student->activeCourses->avg('pivot.attendance_percentage') ?? 100,
        ];

        $recentPayments = $student->payments;
        $courses        = $student->activeCourses;

        return view('dashboard', compact('student', 'stats', 'recentPayments', 'courses'));
    }
}