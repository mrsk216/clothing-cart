<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / max(Order::where('payment_status', 'paid')->count(), 1) : 0;

        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->where('payment_status', 'paid')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('admin.reports.index', compact('totalSales', 'totalOrders', 'avgOrderValue', 'monthlySales'));
    }

    public function export(Request $request, string $type): StreamedResponse
    {
        $filename = $type . '-report-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($type) {
            $handle = fopen('php://output', 'w');

            if ($type === 'orders') {
                fputcsv($handle, ['Order Number', 'Customer', 'Status', 'Payment Status', 'Total', 'Date']);
                Order::with('user')->latest()->chunk(200, function ($orders) use ($handle) {
                    foreach ($orders as $order) {
                        fputcsv($handle, [
                            $order->order_number,
                            $order->user?->name ?? 'Guest',
                            $order->status,
                            $order->payment_status,
                            $order->total,
                            $order->created_at?->toDateTimeString(),
                        ]);
                    }
                });
            } elseif ($type === 'products') {
                fputcsv($handle, ['Product', 'SKU', 'Quantity Sold', 'Revenue']);
                $rows = OrderItem::query()
                    ->select('product_name', 'product_sku', DB::raw('SUM(quantity) as qty'), DB::raw('SUM(subtotal) as revenue'))
                    ->groupBy('product_name', 'product_sku')
                    ->orderByDesc('revenue')
                    ->get();

                foreach ($rows as $row) {
                    fputcsv($handle, [$row->product_name, $row->product_sku, $row->qty, $row->revenue]);
                }
            } else {
                fputcsv($handle, ['Year', 'Month', 'Total Sales']);
                $monthly = Order::select(
                        DB::raw('YEAR(created_at) as year'),
                        DB::raw('MONTH(created_at) as month'),
                        DB::raw('SUM(total) as total')
                    )
                    ->where('payment_status', 'paid')
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();

                foreach ($monthly as $row) {
                    fputcsv($handle, [$row->year, $row->month, $row->total]);
                }
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
