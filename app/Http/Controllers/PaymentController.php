<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function showForm(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('order.detail', $order->id)
                ->with('info', 'This order is already paid.');
        }

        if ($order->payment && $order->payment->status === 'pending') {
            return redirect()->route('order.detail', $order->id)
                ->with('info', 'Payment already submitted for this order. Waiting for verification.');
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('pages.dashboard.payment-submit', compact('order', 'settings'));
    }

    public function submit(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('order.detail', $order->id)
                ->with('error', 'This order is already paid.');
        }

        if ($order->payment && $order->payment->status === 'pending') {
            return redirect()->back()->with('error', 'Payment already submitted and waiting for verification.');
        }

        $request->validate([
            'payment_method' => 'required|in:qr_code,upi,bank_transfer',
            'utr_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('payments', 'utr_number')->ignore($order->payment?->id),
            ],
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $screenshotPath = $request->file('screenshot')->store('payments/screenshots', 'public');

        if ($order->payment) {
            if ($order->payment->screenshot_path) {
                Storage::disk('public')->delete($order->payment->screenshot_path);
            }

            $order->payment->update([
                'amount' => $order->total,
                'payment_method' => $request->payment_method,
                'utr_number' => $request->utr_number,
                'screenshot_path' => $screenshotPath,
                'status' => 'pending',
                'rejection_reason' => null,
                'rejection_details' => null,
                'verified_by' => null,
                'verified_at' => null,
            ]);
        } else {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'payment_method' => $request->payment_method,
                'utr_number' => $request->utr_number,
                'screenshot_path' => $screenshotPath,
                'status' => 'pending',
            ]);
        }

        $order->update([
            'payment_method' => $request->payment_method,
            'status' => 'pending_payment_verification',
            'payment_status' => 'unpaid',
        ]);

        $admins = User::whereIn('role', ['super_admin', 'admin', 'staff'])->get();
        foreach ($admins as $admin) {
            AppNotification::create([
                'user_id' => $admin->id,
                'type' => 'payment',
                'title' => 'Payment verification required',
                'message' => 'Order #' . $order->order_number . ' payment proof re-submitted.',
                'action_url' => route('admin.payment-verification'),
                'is_read' => false,
            ]);
        }

        return redirect()->route('order.detail', $order->id)
            ->with('success', 'Payment proof submitted! Waiting for verification.');
    }
}
