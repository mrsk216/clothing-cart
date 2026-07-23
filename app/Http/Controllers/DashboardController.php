<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function addresses()
    {
        $addresses = Auth::user()->addresses ?? [];
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
