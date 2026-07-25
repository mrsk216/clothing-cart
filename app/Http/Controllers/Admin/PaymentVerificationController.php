<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Payment;
use App\Models\PaymentVerification;
use App\Models\Product;
use App\Notifications\PaymentVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['order.user', 'order.items'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        $logs = PaymentVerification::with(['payment', 'order', 'admin'])
            ->latest()
            ->paginate(15, ['*'], 'logs_page');

        return view('admin.payment-verification.index', compact('payments', 'logs'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:255',
        ]);

        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'This payment has already been processed.');
        }

        $payment->load('order.user', 'order.items');

        DB::transaction(function () use ($request, $payment) {
            $payment->update([
                'status' => $request->status,
                'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);

            PaymentVerification::create([
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'admin_id' => Auth::id(),
                'action' => $request->status,
                'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
            ]);

            $order = $payment->order;

            if ($request->status === 'approved') {
                if (! $order->invoice_number) {
                    $order->invoice_number = $order->generateInvoiceNumber();
                }

                $order->status = 'processing';
                $order->payment_status = 'paid';
                $order->paid_at = now();
                $order->save();

                $this->deductStock($order);
            } else {
                $order->update([
                    'status' => 'pending_payment',
                    'payment_status' => 'unpaid',
                ]);
            }
        });

        $order = $payment->order->fresh(['user', 'items']);

        if ($order && $order->user && $order->user->email) {
            try {
                $order->user->notify(new PaymentVerified(
                    $order,
                    $request->status,
                    $request->status === 'rejected' ? $request->rejection_reason : null
                ));
            } catch (\Throwable $e) {
                report($e);

                return redirect()->route('admin.payment-verification')
                    ->with('success', 'Payment ' . $request->status . ', but email notification failed: ' . $e->getMessage());
            }
        }

        $message = $request->status === 'approved'
            ? 'Payment approved. Customer notified and GST invoice generated.'
            : 'Payment rejected. Customer notified and can re-submit proof.';

        return redirect()->route('admin.payment-verification')->with('success', $message);
    }

    protected function deductStock($order): void
    {
        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            $product = Product::lockForUpdate()->find($item->product_id);
            if (! $product || ! $product->track_stock) {
                continue;
            }

            $qty = (int) $item->quantity;
            $product->update([
                'stock_quantity' => max(0, $product->stock_quantity - $qty),
            ]);

            Inventory::create([
                'product_id' => $product->id,
                'quantity' => $qty,
                'type' => 'deduction',
                'notes' => 'Order ' . $order->order_number . ' payment approved',
                'reference_type' => 'order',
                'reference_id' => $order->id,
            ]);
        }
    }
}
