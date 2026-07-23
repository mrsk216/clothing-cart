<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function shipping()
    {
        return view('pages.shipping');
    }

    public function returns()
    {
        return view('pages.returns');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function home()
    {
        $categories = Category::active()->parents()->with('children')->get();
        $featuredProducts = Product::active()->featured()->with('primaryImage', 'category')->take(8)->get();

        return view('welcome', compact('categories', 'featuredProducts'));
    }
}
