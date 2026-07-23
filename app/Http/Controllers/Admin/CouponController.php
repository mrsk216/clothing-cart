<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());
        return redirect()->back()->with('success', 'Coupon created!');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => ['required', 'string', Rule::unique('coupons')->ignore($coupon->id)],
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update($request->all());
        return redirect()->back()->with('success', 'Coupon created!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', 'Coupon deleted!');
    }
}
