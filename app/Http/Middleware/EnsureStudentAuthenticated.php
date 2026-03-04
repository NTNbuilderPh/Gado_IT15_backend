<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please log in to access this resource.',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        if (Auth::user()->status !== 'active') {
            Auth::logout();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been deactivated.',
                ], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Your account is not active. Contact the registrar.');
        }

        return $next($request);
    }
}