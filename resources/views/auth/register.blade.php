@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="auth-card auth-card-wide">
        <h2>Student Registration</h2>
        <p class="auth-subtitle">University of Mindanao — Tagum Campus</p>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="student_number">Student Number *</label>
                    <input type="text" id="student_number" name="student_number"
                           value="{{ old('student_number') }}"
                           placeholder="e.g. 22-00001" pattern="\d{2}-\d{5}" required>
                    <small>Format: XX-XXXXX</small>
                </div>
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="student@um.edu.ph" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name"
                           value="{{ old('first_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name"
                           value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="program">Program *</label>
                    <select id="program" name="program" required>
                        <option value="">Select Program</option>
                        <option value="BSIT" {{ old('program') === 'BSIT' ? 'selected' : '' }}>BS Information Technology</option>
                        <option value="BSCS" {{ old('program') === 'BSCS' ? 'selected' : '' }}>BS Computer Science</option>
                        <option value="BSIS" {{ old('program') === 'BSIS' ? 'selected' : '' }}>BS Information Systems</option>
                        <option value="ACT" {{ old('program') === 'ACT' ? 'selected' : '' }}>Associate in Computer Technology</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="year_level">Year Level *</label>
                    <select id="year_level" name="year_level" required>
                        <option value="1st Year" {{ old('year_level') === '1st Year' ? 'selected' : '' }}>1st Year</option>
                        <option value="2nd Year" {{ old('year_level') === '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3rd Year" {{ old('year_level') === '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4th Year" {{ old('year_level') === '4th Year' ? 'selected' : '' }}>4th Year</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                           value="{{ old('date_of_birth') }}">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone"
                       value="{{ old('phone') }}" placeholder="09XX-XXX-XXXX">
            </div>

            <div class="form-group">
                <label for="id_photo">Digital ID Photo</label>
                <input type="file" id="id_photo" name="id_photo" accept="image/jpeg,image/png">
                <small>Upload a scanned copy of your UM Student ID (JPG/PNG, max 2MB)</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password"
                           placeholder="Minimum 8 characters" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Re-enter password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <p class="auth-link">
            Already registered? <a href="{{ route('login') }}">Login here</a>
        </p>
    </div>
</div>
@endsection