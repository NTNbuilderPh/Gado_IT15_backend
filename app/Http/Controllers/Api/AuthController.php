<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/auth/login
     * SIS Integration: login with student_number OR email.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginValue = trim($request->login);
        $field      = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_number';
        $student    = Student::where($field, $loginValue)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($student->status !== 'active') {
            throw ValidationException::withMessages([
                'login' => ['Your account is not active.'],
            ]);
        }

        $token = $student->createToken('um-portal-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data'    => [
                'student' => $student,
                'token'   => $token,
            ],
        ]);
    }

    /**
     * POST /api/auth/register
     */
    public function register(Request $request)
    {
        $request->validate([
            'student_number' => 'required|string|unique:students|regex:/^\d{2}-\d{5}$/',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:students',
            'password'       => ['required', 'confirmed', Password::min(8)],
            'program'        => 'required|string',
            'year_level'     => 'required|in:1st Year,2nd Year,3rd Year,4th Year',
        ]);

        $student = Student::create([
            ...$request->only([
                'student_number', 'first_name', 'last_name',
                'email', 'password', 'program', 'year_level',
            ]),
            'tuition_balance' => 15000.00,
        ]);

        $token = $student->createToken('um-portal-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'data'    => [
                'student' => $student,
                'token'   => $token,
            ],
        ], 201);
    }

    /**
     * POST /api/auth/logout (Sanctum protected)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }
}