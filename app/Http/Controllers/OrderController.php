<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = $this->getCart();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        return view('pages.checkout', compact('cart'));
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
            'payment_method' => 'required|in:upi',
        ]);

        $cart = $this->getCart();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => $cart->subtotal,
            'discount' => $cart->discount,
            'total' => $cart->total + ($cart->subtotal >= 500 ? 0 : 50),
            'status' => 'pending_payment',
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
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'subtotal' => $item->subtotal,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        return view('pages.checkout-success', compact('order'));
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
        // Simple invoice download - in production use PDF library
        return response()->json(['message' => 'Invoice download - implement with barryvdh/laravel-dompdf']);
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
}
