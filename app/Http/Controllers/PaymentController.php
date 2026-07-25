<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function showForm(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // If order already has a payment submitted, redirect
        if ($order->payment && $order->status === 'pending_payment_verification') {
            return redirect()->route('order.detail', $order->id)
                ->with('info', 'Payment already submitted for this order. Waiting for verification.');
        }

        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

        return view('pages.dashboard.payment-submit', compact('order', 'settings'));
    }

    public function submit(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:qr_code,upi,bank_transfer',
            'utr_number' => 'required|string|unique:payments,utr_number',
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Check if order already has a payment
        if ($order->payment) {
            return redirect()->back()->with('error', 'Payment already submitted for this order.');
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total,
            'payment_method' => $request->payment_method,
            'utr_number' => $request->utr_number,
            'screenshot_path' => $request->file('screenshot')->store('payments/screenshots', 'public'),
            'status' => 'pending',
        ]);

        $order->update([
            'payment_method' => $request->payment_method,
            'status' => 'pending_payment_verification',
        ]);

        return redirect()->route('checkout.success', $order)->with('success', 'Payment proof submitted! Waiting for verification.');
    }
}
