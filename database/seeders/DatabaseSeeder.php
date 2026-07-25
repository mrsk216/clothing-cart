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
            ['email' => 'admin@spmapp.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create Categories
        $categories = [
            ['name' => 'Paper Products', 'slug' => 'paper-products', 'description' => 'A4, A3, Specialty papers'],
            ['name' => 'Stamp Pads', 'slug' => 'stamp-pads', 'description' => 'Regular, Self-inking, Date stamps'],
            ['name' => 'Rubber Seals', 'slug' => 'rubber-seals', 'description' => 'Custom rubber stamps'],
            ['name' => 'Screen Printing', 'slug' => 'screen-printing-materials', 'description' => 'Inks, emulsions, squeegees'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }

        // Create Products
        $products = [
            ['name' => 'A4 Paper 500 Sheets', 'slug' => 'a4-paper-500-sheets', 'price' => 250, 'compare_price' => 300, 'stock_quantity' => 100, 'category_id' => 1, 'sku' => 'PAP-001'],
            ['name' => 'A3 Paper 250 Sheets', 'slug' => 'a3-paper-250-sheets', 'price' => 450, 'compare_price' => 550, 'stock_quantity' => 50, 'category_id' => 1, 'sku' => 'PAP-002'],
            ['name' => 'Regular Stamp Pad', 'slug' => 'regular-stamp-pad', 'price' => 120, 'compare_price' => 150, 'stock_quantity' => 80, 'category_id' => 2, 'sku' => 'STP-001'],
            ['name' => 'Self-Inking Stamp Pad', 'slug' => 'self-inking-stamp-pad', 'price' => 350, 'compare_price' => 400, 'stock_quantity' => 40, 'category_id' => 2, 'sku' => 'STP-002'],
            ['name' => 'Custom Rubber Stamp', 'slug' => 'custom-rubber-stamp', 'price' => 500, 'compare_price' => 600, 'stock_quantity' => 30, 'category_id' => 3, 'sku' => 'RUB-001'],
            ['name' => 'Screen Printing Ink', 'slug' => 'screen-printing-ink', 'price' => 280, 'compare_price' => 320, 'stock_quantity' => 60, 'category_id' => 4, 'sku' => 'SCR-001'],
            ['name' => 'Squeegee 25cm', 'slug' => 'squeegee-25cm', 'price' => 180, 'compare_price' => 220, 'stock_quantity' => 45, 'category_id' => 4, 'sku' => 'SCR-002'],
            ['name' => 'Photo Emulsion', 'slug' => 'photo-emulsion', 'price' => 450, 'compare_price' => 500, 'stock_quantity' => 25, 'category_id' => 4, 'sku' => 'SCR-003'],
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
        $blogCategory = BlogCategory::updateOrCreate(['slug' => 'news'], [
            'name' => 'News',
            'description' => 'Latest news and updates',
        ]);

        // Create Blog Post
        BlogPost::updateOrCreate(['slug' => 'welcome-to-spm-enterprise'], [
            'title' => 'Welcome to SPM Enterprise',
            'content' => 'We are excited to launch our new e-commerce platform...',
            'excerpt' => 'Welcome to our new online store!',
            'is_published' => true,
            'published_at' => now(),
            'blog_category_id' => $blogCategory->id,
            'author_id' => 1,
        ]);

        // Create Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'SPM Enterprise'],
            ['key' => 'contact_email', 'value' => 'info@spmapp.com'],
            ['key' => 'contact_phone', 'value' => '+91-9876543210'],
            ['key' => 'whatsapp_number', 'value' => '919876543210'],
            ['key' => 'address', 'value' => '123, Business Street, Mumbai - 400001'],
            ['key' => 'gst_number', 'value' => '27AAAAA0000A1Z5'],
            ['key' => 'gst_rate', 'value' => '18'],
            ['key' => 'upi_id', 'value' => 'company@upi'],
            ['key' => 'bank_name', 'value' => 'State Bank of India'],
            ['key' => 'bank_account_name', 'value' => 'SPM Enterprises'],
            ['key' => 'bank_account_number', 'value' => '123456789012'],
            ['key' => 'bank_ifsc_code', 'value' => 'SBIN0001234'],
            ['key' => 'free_shipping_threshold', 'value' => '500'],
            ['key' => 'shipping_charge', 'value' => '50'],
            ['key' => 'meta_description', 'value' => 'Buy paper products, stamp pads, rubber seals and screen printing materials online from SPM Enterprise.'],
            ['key' => 'meta_keywords', 'value' => 'paper, stamp pad, rubber seal, screen printing, wholesale stationery'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
