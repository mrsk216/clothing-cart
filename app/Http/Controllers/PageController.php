<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        ContactMessage::create($validated);

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function bulkEnquiry()
    {
        $categories = Category::active()->parents()->get();

        return view('pages.bulk-enquiry', compact('categories'));
    }

    public function sendBulkEnquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'estimated_quantity' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        $body = "Bulk Order Enquiry\n"
            . 'Company: ' . ($validated['company'] ?? 'N/A') . "\n"
            . 'Category Interest: ' . ($validated['category'] ?? 'N/A') . "\n"
            . 'Estimated Quantity: ' . ($validated['estimated_quantity'] ?? 'N/A') . "\n\n"
            . $validated['message'];

        $message = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => 'Bulk Order / Wholesale',
            'message' => $body,
        ]);

        $admins = User::whereIn('role', ['super_admin', 'admin', 'staff'])->get();
        foreach ($admins as $admin) {
            AppNotification::create([
                'user_id' => $admin->id,
                'type' => 'enquiry',
                'title' => 'New bulk order enquiry',
                'message' => $validated['name'] . ' submitted a bulk order enquiry.',
                'action_url' => route('admin.messages.show', $message),
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Your bulk order enquiry has been submitted. Our team will contact you soon.');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        Subscriber::updateOrCreate(
            ['email' => $request->email],
            ['is_active' => true]
        );

        return back()->with('success', 'Thank you for subscribing!');
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
        $categories = Category::active()->parents()->with('children')->orderBy('id', 'desc')->get();
        $popularProducts = Product::active()->popular()->with('primaryImage', 'category')->orderBy('id', 'desc')->take(4)->get();
        if ($popularProducts->count() < 4) {
            $popularProducts = Product::active()->with('primaryImage', 'category')->orderBy('id', 'desc')->take(4)->get();
        }

        return view('welcome', compact('categories', 'popularProducts'));
    }

    public function sitemap()
    {
        $products = Product::active()->select('slug', 'updated_at')->get();
        $categories = Category::active()->select('slug', 'updated_at')->get();
        $posts = \App\Models\BlogPost::where('is_published', true)->select('slug', 'updated_at')->get();

        $content = view('sitemap', compact('products', 'categories', 'posts'))->render();

        return Response::make($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
