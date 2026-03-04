@extends('layouts.app')
@section('title', 'Grades')

@section('content')
<div class="portal-page">
    <div class="page-header">
        <h1>Grade Report</h1>
        <p>{{ $student->full_name }} — {{ $student->student_number }}</p>
    </div>

    @if($gpa !== null)
    <div class="stats-grid">
        <div class="stat-card stat-card-large">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ $gpa }}</div>
            <div class="stat-label">General Weighted Average</div>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header"><h2>All Courses</h2></div>
        @if($courses->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Units</th>
                    <th>Instructor</th>
                    <th>Status</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td><strong>{{ $course->course_code }}</strong></td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->units }}</td>
                    <td>{{ $course->instructor }}</td>
                    <td>
                        <span class="badge badge-{{ $course->pivot->status === 'enrolled' ? 'success' : ($course->pivot->status === 'dropped' ? 'error' : 'neutral') }}">
                            {{ ucfirst($course->pivot->status) }}
                        </span>
                    </td>
                    <td>
                        @if($course->pivot->grade)
                            <strong class="{{ $course->pivot->grade <= 3.0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($course->pivot->grade, 2) }}
                            </strong>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($course->pivot->grade)
                            @if($course->pivot->grade <= 3.0)
                                <span class="text-success">Passed</span>
                            @else
                                <span class="text-danger">Failed</span>
                            @endif
                        @else
                            <span class="text-muted">In Progress</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state"><p>No course records found.</p></div>
        @endif
    </div>
</div>
@endsection