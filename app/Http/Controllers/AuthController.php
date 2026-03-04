<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeStudent;
use App\Models\Message;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * SIS Integration: authenticate with Student ID OR Email.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Determine if the user entered an email or student number
        $loginValue = trim($request->login);
        $fieldName  = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_number';

        $credentials = [
            $fieldName  => $loginValue,
            'password'  => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $student = Auth::user();

            if ($student->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Your account is not active. Please contact the UM Registrar.',
                ]);
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', "Welcome back, {$student->first_name}!");
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login', 'remember'));
    }

    /**
     * Show registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Register a new student with digital ID upload.
     */
    public function register(Request $request)
    {
        $request->validate([
            'student_number' => 'required|string|unique:students,student_number|regex:/^\d{2}-\d{5}$/',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:students,email',
            'password'       => ['required', 'confirmed', Password::min(8)],
            'phone'          => 'nullable|string|max:15',
            'date_of_birth'  => 'nullable|date|before:today',
            'gender'         => 'nullable|in:Male,Female,Other',
            'program'        => 'required|string',
            'year_level'     => 'required|in:1st Year,2nd Year,3rd Year,4th Year',
            'id_photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['password_confirmation', 'id_photo']);

        // Handle digital ID upload
        if ($request->hasFile('id_photo')) {
            $path = $request->file('id_photo')
                ->store('id_photos', 'public');
            $data['id_photo'] = $path;
        }

        // Set initial tuition balance
        $data['tuition_balance'] = 15000.00;

        $student = Student::create($data);

        // Send welcome email (non-blocking)
        try {
            Mail::to($student->email)->send(new WelcomeStudent($student));
        } catch (\Exception $e) {
            // Log but don't block registration
            \Log::warning('Welcome email failed: ' . $e->getMessage());
        }

        // Create system welcome message
        Message::create([
            'sender_id'      => $student->id,
            'receiver_email' => $student->email,
            'subject'        => 'Welcome to UM Academic Portal!',
            'body'           => "Dear {$student->full_name},\n\nWelcome to the University of Mindanao Academic Portal. "
                              . "Your Student ID is {$student->student_number}. You can use this or your email to log in.\n\n"
                              . "Please proceed to the Enrollment tab to register for your courses.\n\n"
                              . "— UM Registrar Office",
            'type'           => 'welcome',
            'is_read'        => false,
        ]);

        Auth::login($student);

        return redirect()->route('dashboard')
            ->with('success', 'Registration successful! Welcome to the UM Academic Portal.');
    }

    /**
     * Log out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}