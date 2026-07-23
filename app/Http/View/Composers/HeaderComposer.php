<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $categories = Category::active()->parents()->with('children')->get();
        $view->with('categories', $categories);
    }
}
