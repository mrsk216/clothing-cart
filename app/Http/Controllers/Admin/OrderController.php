<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'payment.verificationLogs.admin');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,pending_payment,pending_payment_verification,processing,shipped,delivered,cancelled',
        ]);

        $processingStatuses = ['processing', 'shipped', 'delivered'];

        if (in_array($request->status, $processingStatuses, true) && $order->payment_status !== 'paid') {
            return redirect()->back()->with(
                'error',
                'Cannot move order to processing/shipping until payment is approved.'
            );
        }

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated!');
    }
}
