<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@clothingcart.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create Categories
        $categories = [
            ['name' => "Men's Fashion", 'slug' => 'mens-fashion', 'description' => 'Shirts, T-shirts, Jeans, Formal wear'],
            ['name' => "Women's Fashion", 'slug' => 'womens-fashion', 'description' => 'Dresses, Kurtis, Tops, Ethnic wear'],
            ['name' => "Kids' Fashion", 'slug' => 'kids-fashion', 'description' => 'Kids clothing, School wear, Party wear'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Bags, Watches, Belts, Sunglasses'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Sneakers, Sandals, Formal shoes'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }

        // Create Products
        $products = [
            ['name' => 'Classic White Cotton Shirt', 'slug' => 'classic-white-cotton-shirt', 'price' => 1299, 'compare_price' => 1599, 'stock_quantity' => 100, 'category_id' => 1, 'sku' => 'MEN-001'],
            ['name' => 'Premium Denim Jeans', 'slug' => 'premium-denim-jeans', 'price' => 1999, 'compare_price' => 2499, 'stock_quantity' => 50, 'category_id' => 1, 'sku' => 'MEN-002'],
            ['name' => 'Floral Summer Dress', 'slug' => 'floral-summer-dress', 'price' => 1499, 'compare_price' => 1899, 'stock_quantity' => 80, 'category_id' => 2, 'sku' => 'WOM-001'],
            ['name' => 'Elegant Silk Kurti', 'slug' => 'elegant-silk-kurti', 'price' => 999, 'compare_price' => 1299, 'stock_quantity' => 40, 'category_id' => 2, 'sku' => 'WOM-002'],
            ['name' => 'Kids Party Wear Set', 'slug' => 'kids-party-wear-set', 'price' => 799, 'compare_price' => 999, 'stock_quantity' => 30, 'category_id' => 3, 'sku' => 'KID-001'],
            ['name' => 'Leather Crossbody Bag', 'slug' => 'leather-crossbody-bag', 'price' => 2499, 'compare_price' => 2999, 'stock_quantity' => 60, 'category_id' => 4, 'sku' => 'ACC-001'],
            ['name' => 'Classic Analog Watch', 'slug' => 'classic-analog-watch', 'price' => 3499, 'compare_price' => 3999, 'stock_quantity' => 45, 'category_id' => 4, 'sku' => 'ACC-002'],
            ['name' => 'Running Sneakers', 'slug' => 'running-sneakers', 'price' => 1799, 'compare_price' => 2199, 'stock_quantity' => 25, 'category_id' => 5, 'sku' => 'FTW-001'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }

        // Create Coupons
        Coupon::updateOrCreate(['code' => 'WELCOME10'], [
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
            'usage_limit' => 100,
            'used_count' => 0,
        ]);

        Coupon::updateOrCreate(['code' => 'SAVE50'], [
            'type' => 'fixed',
            'value' => 50,
            'min_order_amount' => 500,
            'is_active' => true,
            'usage_limit' => 50,
            'used_count' => 0,
        ]);

        // Create Blog Category
        $blogCategory = BlogCategory::updateOrCreate(['slug' => 'fashion-tips'], [
            'name' => 'Fashion Tips',
            'description' => 'Style guides and fashion trends',
        ]);

        // Create Blog Post
        BlogPost::updateOrCreate(['slug' => 'welcome-to-clothing-cart'], [
            'title' => 'Welcome to Clothing Cart',
            'content' => 'Discover the latest fashion trends and elevate your style with our premium collection...',
            'excerpt' => 'Welcome to our new fashion destination!',
            'is_published' => true,
            'published_at' => now(),
            'blog_category_id' => $blogCategory->id,
            'author_id' => 1,
        ]);

        // Create Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Clothing Cart'],
            ['key' => 'contact_email', 'value' => 'info@clothingcart.com'],
            ['key' => 'contact_phone', 'value' => '+91-9876543210'],
            ['key' => 'whatsapp_number', 'value' => '919876543210'],
            ['key' => 'address', 'value' => '123, Fashion Street, Mumbai - 400001'],
            ['key' => 'gst_number', 'value' => '27AAAAA0000A1Z5'],
            ['key' => 'gst_rate', 'value' => '18'],
            ['key' => 'upi_id', 'value' => 'company@upi'],
            ['key' => 'bank_name', 'value' => 'State Bank of India'],
            ['key' => 'bank_account_name', 'value' => 'Clothing Cart'],
            ['key' => 'bank_account_number', 'value' => '123456789012'],
            ['key' => 'bank_ifsc_code', 'value' => 'SBIN0001234'],
            ['key' => 'free_shipping_threshold', 'value' => '500'],
            ['key' => 'shipping_charge', 'value' => '50'],
            ['key' => 'meta_description', 'value' => 'Shop premium fashion and clothing online at Clothing Cart. Discover the latest trends in apparel, accessories, and footwear.'],
            ['key' => 'meta_keywords', 'value' => 'fashion, clothing, apparel, mens fashion, womens fashion, kids fashion, accessories, footwear'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
