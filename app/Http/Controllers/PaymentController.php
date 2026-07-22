<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function submit(Request $request, Order $order)
    {
        $request->validate([
            'utr_number' => 'required|string|unique:payments,utr_number',
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total,
            'method' => 'upi',
            'utr_number' => $request->utr_number,
            'screenshot_path' => $request->file('screenshot')->store('payments', 'public'),
            'status' => 'pending',
        ]);

        PaymentVerification::create([
            'payment_id' => $payment->id,
            'status' => 'pending',
        ]);

        $order->update(['status' => 'pending_payment']);

        return redirect()->route('checkout.success', $order)->with('success', 'Payment proof submitted! Waiting for verification.');
    }
}
