<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('primaryImage','category')->orderBy('id', 'desc')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|unique:products',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create($request->all());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Product created!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update($request->all());

        if ($request->hasFile('images')) {
            foreach ($product->images as $oldImage) {
                \Storage::disk('public')->delete($oldImage->image_path);
            }
            $product->images()->delete();
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }
        return redirect()->route('admin.products')->with('success', 'Product updated!');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        $status = $product->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Product {$status}!");
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $oldImage) {
            \Storage::disk('public')->delete($oldImage->image_path);
        }
        $product->images()->delete();
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted!');
    }
}
