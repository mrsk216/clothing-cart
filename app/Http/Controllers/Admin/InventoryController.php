<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'name', 'sku', 'stock_quantity', 'low_stock_threshold', 'track_stock')
            ->orderBy('name')
            ->paginate(20);

        $allProducts = Product::select('id', 'name', 'stock_quantity')
            ->orderBy('name')
            ->get();

        $recentLogs = Inventory::with('product:id,name,sku')
            ->latest()
            ->take(15)
            ->get();

        return view('admin.inventory.index', compact('products', 'allProducts', 'recentLogs'));
    }

    public function adjust(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:add,remove',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'remove' && $product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock!');
        }

        DB::transaction(function () use ($request, $product) {
            $newQty = $request->type === 'add'
                ? $product->stock_quantity + $request->quantity
                : $product->stock_quantity - $request->quantity;

            $product->update(['stock_quantity' => $newQty]);

            Inventory::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'type' => $request->type === 'add' ? 'addition' : 'deduction',
                'notes' => $request->notes,
                'reference_type' => 'manual',
            ]);
        });

        return redirect()->back()->with('success', 'Stock adjusted successfully!');
    }
}
