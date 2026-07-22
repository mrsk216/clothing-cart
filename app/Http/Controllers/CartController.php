<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        return view('pages.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);

        $product = Product::active()->findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = $this->getOrCreateCart();
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'subtotal' => ($existingItem->quantity + $quantity) * $existingItem->unit_price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->final_price,
                'subtotal' => $quantity * $product->final_price,
            ]);
        }

        return response()->json([
            'success' => true,
            'count' => $cart->fresh()->items->sum('quantity'),
            'message' => 'Product added to cart!'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        $item = CartItem::findOrFail($request->item_id);
        $item->update([
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $item->unit_price,
        ]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:cart_items,id']);
        CartItem::findOrFail($request->item_id)->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function count()
    {
        $cart = $this->getCart();
        return response()->json(['count' => $cart ? $cart->items->sum('quantity') : 0]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code!');
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return back()->with('error', 'Coupon usage limit reached!');
        }

        $cart = $this->getCart();
        $subtotal = $cart->subtotal;

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return back()->with('error', 'Minimum order amount not met!');
        }

        $discount = $coupon->type === 'percentage'
            ? ($subtotal * $coupon->value / 100)
            : $coupon->value;

        if ($coupon->max_discount) {
            $discount = min($discount, $coupon->max_discount);
        }

        $cart->update(['coupon_code' => $coupon->code, 'discount' => $discount]);
        return back()->with('success', 'Coupon applied successfully!');
    }

    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with('items.product.primaryImage')->first();
        }
        $sessionId = session()->getId();
        return Cart::where('session_id', $sessionId)->with('items.product.primaryImage')->first();
    }

    private function getOrCreateCart()
    {
        $cart = $this->getCart();
        if (!$cart) {
            $data = Auth::check()
                ? ['user_id' => Auth::id()]
                : ['session_id' => session()->getId()];
            $cart = Cart::create($data);
        }
        return $cart;
    }
}
