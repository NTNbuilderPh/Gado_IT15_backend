@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2>Student Login</h2>
        <p class="auth-subtitle">Use your Student ID or Email to access the portal</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="login">Student ID / Email</label>
                <input
                    type="text"
                    id="login"
                    name="login"
                    value="{{ old('login') }}"
                    placeholder="e.g. 22-00001 or student@um.edu.ph"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login to Portal</button>
        </form>

        <p class="auth-link">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </p>
    </div>
</div>
@endsection