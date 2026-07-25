<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;

use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;

Route::get('/', [PageController::class, 'home'])->name('home');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::get('/bulk-enquiry', [PageController::class, 'bulkEnquiry'])->name('bulk.enquiry');
Route::post('/bulk-enquiry', [PageController::class, 'sendBulkEnquiry'])->name('bulk.enquiry.send');
Route::post('/newsletter/subscribe', [PageController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/shipping-policy', [PageController::class, 'shipping'])->name('shipping');
Route::get('/return-policy', [PageController::class, 'returns'])->name('returns');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');

// Shop Routes
Route::get('/products', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Checkout Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [OrderController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
Route::get('/checkout/failed', [OrderController::class, 'failed'])->name('checkout.failed');

// Order Tracking
Route::get('/track-order', [OrderController::class, 'trackOrderForm'])->name('track.order');
Route::post('/track-order', [OrderController::class, 'trackOrder'])->name('track.order.search');

// Wishlist
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.delete');

// Blog
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Blog Comments (authenticated customers)
Route::middleware(['auth'])->group(function () {
    Route::post('/blog/{post}/comment', [App\Http\Controllers\BlogCommentController::class, 'store'])->name('blog.comment.store');
});

// Auth Routes (Fortify)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
    Route::get('/order/{id}', [DashboardController::class, 'orderDetail'])->name('order.detail');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('profile.password');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::get('/addresses', [DashboardController::class, 'addresses'])->name('addresses');
    Route::get('/download-invoice/{order}', [OrderController::class, 'downloadInvoice'])->name('invoice.download');
    Route::get('/invoice/{order}', [OrderController::class, 'viewInvoice'])->name('invoice.view');
    Route::get('/payment/submit/{order}', [PaymentController::class, 'showForm'])->name('payment.form');
    Route::post('/payment/submit/{order}', [PaymentController::class, 'submit'])->name('payment.submit');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    // Review Routes
    Route::post('/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::get('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/payment-verification', [App\Http\Controllers\Admin\PaymentVerificationController::class, 'index'])->name('payment-verification');
    Route::post('/payment-verify/{payment}', [App\Http\Controllers\Admin\PaymentVerificationController::class, 'verify'])->name('payment.verify');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::get('/coupons', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons');
    Route::post('/coupons', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/{type}', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
    Route::get('/blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('blog');
    Route::get('/blog/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('blog.destroy');
    Route::get('/blog/categories', [App\Http\Controllers\Admin\BlogCategoryController::class, 'index'])->name('blog.categories');
    Route::get('/blog/categories/create', [App\Http\Controllers\Admin\BlogCategoryController::class, 'create'])->name('blog.categories.create');
    Route::post('/blog/categories', [App\Http\Controllers\Admin\BlogCategoryController::class, 'store'])->name('blog.categories.store');
    Route::get('/blog/categories/{category}/edit', [App\Http\Controllers\Admin\BlogCategoryController::class, 'edit'])->name('blog.categories.edit');
    Route::put('/blog/categories/{category}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'update'])->name('blog.categories.update');
    Route::delete('/blog/categories/{category}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'destroy'])->name('blog.categories.destroy');
    Route::get('/blog/comments', [App\Http\Controllers\Admin\BlogCommentController::class, 'index'])->name('blog.comments');
    Route::post('/blog/comments/{comment}/approve', [App\Http\Controllers\Admin\BlogCommentController::class, 'approve'])->name('blog.comments.approve');
    Route::delete('/blog/comments/{comment}', [App\Http\Controllers\Admin\BlogCommentController::class, 'destroy'])->name('blog.comments.destroy');
    Route::get('/messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages');
    Route::get('/messages/{message}', [App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('messages.reply');
    Route::get('/inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/adjust', [App\Http\Controllers\Admin\InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews');
    Route::post('/reviews/{review}/approve', [App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
});
