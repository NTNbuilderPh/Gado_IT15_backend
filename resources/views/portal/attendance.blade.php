@extends('layouts.app')
@section('title', 'Attendance')

@section('content')
<div class="portal-page">
    <div class="page-header">
        <h1>Attendance Record</h1>
        <p>{{ $student->full_name }} — {{ $student->student_number }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card stat-card-large">
            <div class="stat-icon">✅</div>
            <div class="stat-value {{ $averageAttendance >= 80 ? 'text-success' : 'text-danger' }}">
                {{ number_format($averageAttendance, 1) }}%
            </div>
            <div class="stat-label">Average Attendance</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h2>Course Attendance</h2></div>
        @if($courses->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Schedule</th>
                    <th>Attendance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td><strong>{{ $course->course_code }}</strong></td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->schedule }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill {{ $course->pivot->attendance_percentage >= 80 ? 'good' : 'warning' }}"
                                 style="width: {{ $course->pivot->attendance_percentage }}%">
                            </div>
                        </div>
                        <strong>{{ $course->pivot->attendance_percentage }}%</strong>
                    </td>
                    <td>
                        @if($course->pivot->attendance_percentage >= 80)
                            <span class="badge badge-success">Good Standing</span>
                        @else
                            <span class="badge badge-error">At Risk</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state"><p>No attendance records found.</p></div>
        @endif
    </div>
</div>
@endsection