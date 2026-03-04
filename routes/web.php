<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GADO_IT15_ENROLLMENT_SYSTEM — Web Routes
| University of Mindanao (Tagum Campus)
|--------------------------------------------------------------------------
*/

// ─── Public ──────────────────────────────────────────────
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');

// ─── Authentication ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('student.auth')
    ->name('logout');

// ─── Authenticated Student Portal ───────────────────────
Route::middleware('student.auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Enrollment
    Route::get('/enrollment',            [EnrollmentController::class, 'index'])->name('enrollment.index');
    Route::post('/enrollment',           [EnrollmentController::class, 'store'])->name('enrollment.store');
    Route::delete('/enrollment/{course}',[EnrollmentController::class, 'destroy'])->name('enrollment.destroy');

    // Academic Portal
    Route::get('/portal/grades',     [PortalController::class, 'grades'])->name('portal.grades');
    Route::get('/portal/attendance', [PortalController::class, 'attendance'])->name('portal.attendance');

    // Finance
    Route::get('/finance',          [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance/payment', [FinanceController::class, 'processPayment'])->name('finance.payment');

    // Messages
    Route::get('/messages',  [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});
