<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Address;
use App\Models\Setting;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = $this->getCart();
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $customerAddress = Address::where('user_id', Auth::id())->where('is_default', true)->first();
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('pages.checkout', compact('cart', 'customerAddress', 'settings'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'payment_method' => 'required|in:qr_code,upi,bank_transfer',
            'utr_number' => ['required', 'string', 'max:100', Rule::unique('payments', 'utr_number')],
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $cart = $this->getCart();
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $shippingCharge = $cart->subtotal >= 500 ? 0 : 50;
        $total = $cart->total + $shippingCharge;

        $order = DB::transaction(function () use ($request, $cart, $shippingCharge, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $cart->subtotal,
                'discount' => $cart->discount,
                'shipping_charge' => $shippingCharge,
                'total' => $total,
                'status' => 'pending_payment_verification',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'shipping_name' => $request->name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_pincode' => $request->pincode,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name ?? 'Product',
                    'product_sku' => $item->product->sku ?? 'N/A',
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $screenshotPath = $request->file('screenshot')->store('payments/screenshots', 'public');

            Payment::create([
                'order_id' => $order->id,
                'utr_number' => $request->utr_number,
                'amount' => $total,
                'payment_method' => $request->payment_method,
                'screenshot_path' => $screenshotPath,
                'status' => 'pending',
            ]);

            $cart->items()->delete();
            $cart->delete();

            return $order;
        });

        $this->notifyAdminsOfPayment($order);

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Order placed! Payment submitted for verification.');
    }

    public function success(Order $order)
    {
        return view('pages.checkout-success', compact('order'));
    }

    public function failed()
    {
        return redirect()->route('checkout')->with('error', 'Payment could not be processed. Please try again.');
    }

    public function myOrders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('pages.dashboard.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('pages.dashboard.order-detail', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status !== 'paid' || ! $order->invoice_number) {
            return redirect()->route('order.detail', $order->id)
                ->with('error', 'Invoice is available after payment is approved.');
        }

        $filename = 'invoice-' . $order->invoice_number . '.pdf';

        return app(\App\Services\InvoiceService::class)
            ->pdf($order)
            ->download($filename);
    }

    public function viewInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status !== 'paid' || ! $order->invoice_number) {
            return redirect()->route('order.detail', $order->id)
                ->with('error', 'Invoice is available after payment is approved.');
        }

        $filename = 'invoice-' . $order->invoice_number . '.pdf';

        return app(\App\Services\InvoiceService::class)
            ->pdf($order)
            ->stream($filename);
    }

    public function trackOrderForm()
    {
        return view('pages.track-order');
    }

    public function trackOrder(Request $request)
    {
        $request->validate(['order_number' => 'required']);
        $order = Order::where('order_number', $request->order_number)->first();

        return view('pages.track-order', compact('order'));
    }

    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with('items.product')->first();
        }

        return Cart::where('session_id', session()->getId())->with('items.product')->first();
    }

    private function notifyAdminsOfPayment(Order $order): void
    {
        $admins = User::whereIn('role', ['super_admin', 'admin', 'staff'])->get();

        foreach ($admins as $admin) {
            AppNotification::create([
                'user_id' => $admin->id,
                'type' => 'payment',
                'title' => 'Payment verification required',
                'message' => 'Order #' . $order->order_number . ' awaits payment verification (₹' . number_format($order->total, 2) . ').',
                'action_url' => route('admin.payment-verification'),
                'is_read' => false,
            ]);
        }
    }
}
