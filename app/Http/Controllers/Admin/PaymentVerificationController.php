<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.user')->latest()->paginate(20);
        return view('admin.payment-verification.index', compact('payments'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $payment->update([
            'status' => $request->status,
            'rejection_reason' => $request->rejection_reason,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        if ($request->status === 'approved') {
            $payment->order->update(['status' => 'processing']);
        }

        return redirect()->back()->with('success', 'Payment ' . $request->status . '!');
    }
}
