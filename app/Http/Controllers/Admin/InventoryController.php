<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'name', 'sku', 'stock_quantity')->get();
        return view('admin.inventory.index', compact('products'));
    }

    public function adjust(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'type' => 'required|in:add,remove',
        ]);

        if ($request->type === 'remove' && $product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock!');
        }

        $product->update([
            'stock_quantity' => $request->type === 'add'
                ? $product->stock_quantity + $request->quantity
                : $product->stock_quantity - $request->quantity
        ]);

        return redirect()->back()->with('success', 'Stock adjusted!');
    }
}
