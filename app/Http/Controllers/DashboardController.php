<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalOrders = $user->orders()->count();
        $completedOrders = $user->orders()->where('status', 'delivered')->count();
        $wishlistCount = $user->wishlists()->count();
        $recentOrders = $user->orders()->latest()->take(5)->get();

        return view('pages.dashboard.index', compact(
            'totalOrders',
            'completedOrders',
            'wishlistCount',
            'recentOrders'
        ));
    }

    public function profile()
    {
        return view('pages.dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile')->with('success', 'Password changed successfully!');
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses ?? collect();
        return view('pages.dashboard.addresses', compact('addresses'));
    }

    public function orders()
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
}