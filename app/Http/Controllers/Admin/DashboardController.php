<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders' => Order::count(),
            'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'products' => Product::count(),
            'users' => User::where('role', 'customer')->count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $pendingVerifications = Payment::where('status', 'pending')->with('order')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingVerifications'));
    }
}
