<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * GET /api/profile
     */
    public function profile(Request $request)
    {
        $student = $request->user();
        $student->load('activeCourses');

        return response()->json([
            'success' => true,
            'data'    => [
                'student'     => $student,
                'total_units' => $student->total_units,
                'gpa'         => $student->gpa,
            ],
        ]);
    }

    /**
     * PUT /api/profile
     */
    public function update(Request $request)
    {
        $student = $request->user();

        $request->validate([
            'phone'         => 'nullable|string|max:15',
            'address'       => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender'        => 'nullable|in:Male,Female,Other',
        ]);

        $student->update($request->only(['phone', 'address', 'date_of_birth', 'gender']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated.',
            'data'    => $student->fresh(),
        ]);
    }

    /**
     * GET /api/finance
     */
    public function finance(Request $request)
    {
        $student  = $request->user();
        $payments = $student->payments()->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => [
                'tuition_balance'     => $student->tuition_balance,
                'scholarship_balance' => $student->scholarship_balance,
                'total_paid'          => $student->payments()->where('status', 'completed')->sum('amount'),
                'payments'            => $payments,
            ],
        ]);
    }

    /**
     * POST /api/payment
     */
    public function payment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:100000',
            'method' => 'required|in:cash,gcash,bank_transfer,scholarship',
        ]);

        $student = $request->user();
        $amount  = (float) $request->amount;

        if ($request->method === 'scholarship' && $student->scholarship_balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient scholarship balance.',
            ], 422);
        }

        $payment = DB::transaction(function () use ($student, $amount, $request) {
            $payment = Payment::create([
                'student_id'       => $student->id,
                'reference_number' => Payment::generateReference(),
                'amount'           => $amount,
                'type'             => 'tuition',
                'method'           => $request->method,
                'description'      => "Tuition payment via {$request->method}",
                'status'           => 'completed',
                'paid_at'          => now(),
            ]);

            $student->decrement('tuition_balance', $amount);

            if ($request->method === 'scholarship') {
                $student->decrement('scholarship_balance', $amount);
            }

            return $payment;
        });

        return response()->json([
            'success' => true,
            'message' => 'Payment processed.',
            'data'    => $payment,
        ], 201);
    }
}