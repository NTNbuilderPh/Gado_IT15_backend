<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Mindanao — Academic Portal</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="welcome-page">
    <div class="welcome-container">
        <div class="welcome-card">
            <img src="{{ asset('images/um-logo.png') }}" alt="UM Logo" class="welcome-logo" onerror="this.style.display='none'">
            <h1>University of Mindanao</h1>
            <h2>Tagum Campus</h2>
            <p class="welcome-subtitle">Academic Portal — Enrollment System</p>
            <p class="welcome-desc">
                A comprehensive enrollment and academic management portal for IT15
                (Web Systems and Technologies).
            </p>
            <div class="welcome-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">Student Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">New Registration</a>
            </div>
            <div class="welcome-footer">
                <p>GADO_IT15_ENROLLMENT_SYSTEM &bull; {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
