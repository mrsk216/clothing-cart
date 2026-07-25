<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentVerification;
use App\Notifications\PaymentVerified;
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

        // Create verification log
        PaymentVerification::create([
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'admin_id' => Auth::id(),
            'action' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        if ($request->status === 'approved') {
            $payment->order->update([
                'status' => 'processing',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        // Send notification to customer
        $order = $payment->order;
        if ($order && $order->user) {
            $order->user->notify(new PaymentVerified(
                $order,
                $request->status,
                $request->status === 'rejected' ? $request->rejection_reason : null
            ));
        }

        return redirect()->back()->with('success', 'Payment ' . $request->status . '!');
    }
}
