<?php

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'SPM Enterprise']);
    Setting::updateOrCreate(['key' => 'contact_email'], ['value' => 'info@spmapp.com']);
    Setting::updateOrCreate(['key' => 'contact_phone'], ['value' => '+91-9876543210']);
    Setting::updateOrCreate(['key' => 'whatsapp_number'], ['value' => '919876543210']);
    Setting::updateOrCreate(['key' => 'address'], ['value' => 'Mumbai']);
});

test('home page loads', function () {
    $this->get(route('home'))->assertOk();
});

test('shop page loads with price filters', function () {
    $category = Category::create([
        'name' => 'Paper',
        'slug' => 'paper-test',
        'is_active' => true,
    ]);

    Product::create([
        'name' => 'A4 Paper',
        'slug' => 'a4-paper-test',
        'price' => 250,
        'stock_quantity' => 10,
        'category_id' => $category->id,
        'sku' => 'PAP-TEST-1',
        'is_active' => true,
    ]);

    $this->get(route('shop', ['min_price' => 100, 'max_price' => 300]))
        ->assertOk()
        ->assertSee('A4 Paper');
});

test('bulk enquiry page and submission work', function () {
    $this->get(route('bulk.enquiry'))->assertOk();

    $this->post(route('bulk.enquiry.send'), [
        'name' => 'Wholesale Buyer',
        'email' => 'buyer@example.com',
        'phone' => '9876543210',
        'company' => 'ABC Traders',
        'category' => 'Paper Products',
        'estimated_quantity' => '500',
        'message' => 'Need wholesale rates for A4 paper.',
    ])->assertRedirect();

    expect(ContactMessage::where('subject', 'Bulk Order / Wholesale')->exists())->toBeTrue();
});

test('newsletter subscription works', function () {
    $this->post(route('newsletter.subscribe'), [
        'email' => 'news@example.com',
    ])->assertRedirect();

    expect(Subscriber::where('email', 'news@example.com')->exists())->toBeTrue();
});

test('sitemap is available', function () {
    $this->get(route('sitemap'))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml');
});

test('admin cannot process unpaid orders', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $customer = User::factory()->create(['role' => 'customer']);

    $order = Order::create([
        'user_id' => $customer->id,
        'order_number' => 'ORD-TEST-001',
        'subtotal' => 100,
        'discount' => 0,
        'shipping_charge' => 0,
        'total' => 100,
        'status' => 'pending_payment_verification',
        'payment_status' => 'unpaid',
        'shipping_name' => 'Test',
        'shipping_phone' => '9999999999',
        'shipping_address' => 'Addr',
        'shipping_city' => 'City',
        'shipping_state' => 'State',
        'shipping_pincode' => '400001',
    ]);

    $this->actingAs($admin)
        ->put(route('admin.orders.status', $order), ['status' => 'processing'])
        ->assertRedirect()
        ->assertSessionHas('error');

    expect($order->fresh()->status)->toBe('pending_payment_verification');
});

test('utr must be unique across payments', function () {
    Storage::fake('public');

    $customer = User::factory()->create(['role' => 'customer']);
    $orderA = Order::create([
        'user_id' => $customer->id,
        'order_number' => 'ORD-UTR-A',
        'subtotal' => 100,
        'discount' => 0,
        'shipping_charge' => 0,
        'total' => 100,
        'status' => 'pending_payment',
        'payment_status' => 'unpaid',
        'shipping_name' => 'Test',
        'shipping_phone' => '9999999999',
        'shipping_address' => 'Addr',
        'shipping_city' => 'City',
        'shipping_state' => 'State',
        'shipping_pincode' => '400001',
    ]);

    Payment::create([
        'order_id' => $orderA->id,
        'utr_number' => 'UTR123456789',
        'amount' => 100,
        'payment_method' => 'upi',
        'screenshot_path' => 'payments/screenshots/a.jpg',
        'status' => 'rejected',
    ]);

    $orderB = Order::create([
        'user_id' => $customer->id,
        'order_number' => 'ORD-UTR-B',
        'subtotal' => 200,
        'discount' => 0,
        'shipping_charge' => 0,
        'total' => 200,
        'status' => 'pending_payment',
        'payment_status' => 'unpaid',
        'shipping_name' => 'Test',
        'shipping_phone' => '9999999999',
        'shipping_address' => 'Addr',
        'shipping_city' => 'City',
        'shipping_state' => 'State',
        'shipping_pincode' => '400001',
    ]);

    $file = UploadedFile::fake()->image('proof.jpg')->size(100);

    $this->actingAs($customer)
        ->post(route('payment.submit', $orderB), [
            'payment_method' => 'upi',
            'utr_number' => 'UTR123456789',
            'screenshot' => $file,
        ])
        ->assertSessionHasErrors('utr_number');
});
