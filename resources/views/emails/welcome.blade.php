<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .email-card { background: #fff; max-width: 600px; margin: 0 auto; border-radius: 8px; overflow: hidden; }
        .email-header { background: #800000; color: #fff; padding: 30px; text-align: center; }
        .email-body { padding: 30px; }
        .email-footer { background: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #777; }
        .info-row { margin: 10px 0; }
        .info-label { font-weight: bold; color: #800000; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="email-header">
            <h1>Welcome to UM!</h1>
            <p>University of Mindanao — Tagum Campus</p>
        </div>
        <div class="email-body">
            <p>Dear <strong>{{ $student->full_name }}</strong>,</p>
            <p>Welcome to the University of Mindanao Academic Portal! Your account has been created successfully.</p>

            <div class="info-row"><span class="info-label">Student ID:</span> {{ $student->student_number }}</div>
            <div class="info-row"><span class="info-label">Program:</span> {{ $student->program }}</div>
            <div class="info-row"><span class="info-label">Year Level:</span> {{ $student->year_level }}</div>
            <div class="info-row"><span class="info-label">Email:</span> {{ $student->email }}</div>

            <p style="margin-top:20px;">You can log in using your <strong>Student ID</strong> or <strong>Email</strong>.</p>
            <p>Please proceed to the <strong>Enrollment</strong> tab to register for your courses.</p>
            <p>Best regards,<br><strong>UM Registrar Office</strong></p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} University of Mindanao — Tagum Campus | IT15 Web Systems and Technologies</p>
        </div>
    </div>
</body>
</html>