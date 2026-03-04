<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GADO_IT15_ENROLLMENT_SYSTEM — API Routes (Laravel Sanctum)
| University of Mindanao (Tagum Campus)
|
| Test with Postman:  https://www.postman.com/
| Base URL:           http://localhost:8000/api
|--------------------------------------------------------------------------
*/

// ─── Public Auth Endpoints ───────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// ─── Protected Endpoints (Sanctum Token) ─────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Student Profile
    Route::get('/profile',  [StudentController::class, 'profile']);
    Route::put('/profile',  [StudentController::class, 'update']);

    // Course Catalog
    Route::get('/courses',      [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);

    // Enrollment
    Route::post('/enrollment',           [EnrollmentController::class, 'store']);
    Route::delete('/enrollment/{course}',[EnrollmentController::class, 'destroy']);

    // Academic Tracking
    Route::get('/grades',     [EnrollmentController::class, 'grades']);
    Route::get('/attendance', [EnrollmentController::class, 'attendance']);

    // Finance
    Route::get('/finance',  [StudentController::class, 'finance']);
    Route::post('/payment', [StudentController::class, 'payment']);
});