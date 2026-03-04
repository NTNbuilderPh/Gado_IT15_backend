@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
    <div class="page-header">
        <h1>Welcome, {{ $student->first_name }}!</h1>
        <p>{{ $student->program }} — {{ $student->year_level }} | {{ $student->semester }}, A.Y. {{ $student->academic_year }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-value">{{ $stats['enrolled_courses'] }}</div>
            <div class="stat-label">Enrolled Courses</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-value">{{ $stats['total_units'] }}</div>
            <div class="stat-label">Total Units</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ $stats['gpa'] ?? 'N/A' }}</div>
            <div class="stat-label">Current GPA</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ number_format($stats['attendance_avg'], 1) }}%</div>
            <div class="stat-label">Avg. Attendance</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">₱{{ number_format($stats['tuition_balance'], 2) }}</div>
            <div class="stat-label">Tuition Balance</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎓</div>
            <div class="stat-value">₱{{ number_format($stats['scholarship'], 2) }}</div>
            <div class="stat-label">Scholarship Balance</div>
        </div>
    </div>

    {{-- Enrolled Courses --}}
    <div class="card">
        <div class="card-header">
            <h2>My Enrolled Courses</h2>
            <a href="{{ route('enrollment.index') }}" class="btn btn-sm btn-primary">+ Enroll More</a>
        </div>
        @if($courses->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Instructor</th>
                    <th>Room</th>
                    <th>Grade</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td><strong>{{ $course->course_code }}</strong></td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->units }}</td>
                    <td>{{ $course->schedule }}</td>
                    <td>{{ $course->instructor }}</td>
                    <td>{{ $course->room }}</td>
                    <td>
                        @if($course->pivot->grade)
                            <span class="badge {{ $course->pivot->grade <= 2.0 ? 'badge-success' : 'badge-warning' }}">
                                {{ $course->pivot->grade }}
                            </span>
                        @else
                            <span class="badge badge-neutral">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill {{ $course->pivot->attendance_percentage >= 80 ? 'good' : 'warning' }}"
                                 style="width: {{ $course->pivot->attendance_percentage }}%">
                            </div>
                        </div>
                        <small>{{ $course->pivot->attendance_percentage }}%</small>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <p>You haven't enrolled in any courses yet.</p>
            <a href="{{ route('enrollment.index') }}" class="btn btn-primary">Browse Courses</a>
        </div>
        @endif
    </div>

    {{-- Recent Payments --}}
    @if($recentPayments->count() > 0)
    <div class="card">
        <div class="card-header">
            <h2>Recent Payments</h2>
            <a href="{{ route('finance.index') }}" class="btn btn-sm btn-secondary">View All</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentPayments as $payment)
                <tr>
                    <td>{{ $payment->reference_number }}</td>
                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->method) }}</td>
                    <td><span class="badge badge-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($payment->status) }}</span></td>
                    <td>{{ $payment->paid_at?->format('M d, Y') ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection