@extends('layouts.app')
@section('title', 'Course Enrollment')

@section('content')
<div class="enrollment-page">
    <div class="page-header">
        <h1>Course Enrollment</h1>
        <p>{{ $student->semester }}, A.Y. {{ $student->academic_year }} — {{ $student->program }}</p>
    </div>

    {{-- My Enrolled Courses --}}
    <div class="card">
        <div class="card-header">
            <h2>My Enrolled Courses ({{ count($enrolledCourseIds) }})</h2>
        </div>
        @php $enrolled = $student->activeCourses; @endphp
        @if($enrolled->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Instructor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrolled as $course)
                <tr>
                    <td><strong>{{ $course->course_code }}</strong></td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->units }}</td>
                    <td>{{ $course->schedule }}</td>
                    <td>{{ $course->instructor }}</td>
                    <td>
                        <form method="POST" action="{{ route('enrollment.destroy', $course) }}"
                              onsubmit="return confirm('Drop {{ $course->course_code }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Drop</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-muted">Total Units: <strong>{{ $enrolled->sum('units') }}</strong></p>
        @else
        <div class="empty-state">
            <p>No courses enrolled yet. Browse available courses below.</p>
        </div>
        @endif
    </div>

    {{-- Available Courses --}}
    <div class="card">
        <div class="card-header">
            <h2>Available Courses</h2>
        </div>
        <table class="data-table" id="courses-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Name</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Instructor</th>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($availableCourses as $course)
                <tr class="{{ $course->students_count >= $course->capacity ? 'row-full' : '' }}">
                    <td><strong>{{ $course->course_code }}</strong></td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->units }}</td>
                    <td>{{ $course->schedule }}</td>
                    <td>{{ $course->instructor }}</td>
                    <td>{{ $course->room }}</td>
                    <td>
                        <span class="capacity-indicator {{ $course->students_count >= $course->capacity ? 'full' : 'available' }}"
                              data-capacity="{{ $course->capacity }}"
                              data-count="{{ $course->students_count }}">
                            {{ $course->students_count }}/{{ $course->capacity }}
                        </span>
                    </td>
                    <td>
                        @if(in_array($course->id, $enrolledCourseIds))
                            <span class="badge badge-success">Enrolled ✓</span>
                        @elseif($course->students_count >= $course->capacity)
                            <span class="badge badge-error">Full</span>
                        @else
                            <form method="POST" action="{{ route('enrollment.store') }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="btn btn-sm btn-primary">Enroll</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection