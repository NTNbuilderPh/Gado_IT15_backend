<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Financial ledger overview.
     */
    public function index()
    {
        $student  = Auth::user();
        $payments = $student->payments()->latest()->paginate(10);

        $summary = [
            'tuition_balance'    => $student->tuition_balance,
            'scholarship_balance'=> $student->scholarship_balance,
            'total_paid'         => $student->payments()->where('status', 'completed')->sum('amount'),
        ];

        return view('finance.index', compact('student', 'payments', 'summary'));
    }

    /**
     * Process a tuition payment.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:100000',
            'method' => 'required|in:cash,gcash,bank_transfer,scholarship',
        ]);

        $student = Auth::user();
        $amount  = (float) $request->amount;

        // Scholarship payment: check balance
        if ($request->method === 'scholarship') {
            if ($student->scholarship_balance < $amount) {
                return back()->withErrors([
                    'amount' => 'Insufficient scholarship balance.',
                ]);
            }
        }

        DB::transaction(function () use ($student, $amount, $request) {
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

            // Update balances
            $student->decrement('tuition_balance', $amount);

            if ($request->method === 'scholarship') {
                $student->decrement('scholarship_balance', $amount);
            }
        });

        return back()->with('success', "Payment of ₱" . number_format($amount, 2) . " processed successfully!");
    }
}