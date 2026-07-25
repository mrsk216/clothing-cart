<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($request->order_id);
        $product = Product::findOrFail($request->product_id);

        // Ensure order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        // Ensure order is delivered
        if ($order->status !== 'delivered') {
            return back()->with('error', 'You can only review products from delivered orders.');
        }

        // Ensure the product was in this order
        $item = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$item) {
            return back()->with('error', 'This product was not in your order.');
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible after admin approval.');
    }
}
