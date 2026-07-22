<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->where('status', '!=', 'cancelled')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('admin.reports.index', compact('totalSales', 'totalOrders', 'avgOrderValue', 'monthlySales'));
    }

    public function export(Request $request, $type)
    {
        // Export functionality - implement with Laravel Excel package
        return redirect()->back()->with('info', 'Export feature - use maatwebsite/excel package');
    }
}
