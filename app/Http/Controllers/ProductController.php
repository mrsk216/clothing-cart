<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function shop(Request $request)
    {
        $query = Product::active()->with('primaryImage', 'category');

        if ($request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = [$category->id];
                $categoryIds = array_merge($categoryIds, $category->children->pluck('id')->toArray());
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->min_price) $query->where('price', '>=', $request->min_price);
        if ($request->max_price) $query->where('price', '<=', $request->max_price);

        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'price-low': $query->orderBy('price', 'asc'); break;
            case 'price-high': $query->orderBy('price', 'desc'); break;
            case 'name': $query->orderBy('name', 'asc'); break;
            default: $query->latest(); break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->parents()->with('children')->get();

        return view('pages.shop', compact('products', 'categories'));
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['images', 'primaryImage', 'category', 'reviews' => function ($q) {
                $q->approved()->with('user');
            }])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->with('primaryImage')
            ->take(4)
            ->get();

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $products = Product::active()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->with('primaryImage')
            ->take(5)
            ->get();

        return response()->json($products);
    }
}
