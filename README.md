# Clothing Cart - Fashion & Clothing E-Commerce Platform

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Clothing Cart is a modern, colorful, and fully-featured fashion & clothing e-commerce platform built with Laravel 12, Tailwind CSS 4, and Alpine.js. It provides a complete online shopping experience with a vibrant, animated, and modern UI design.

## ✨ Features

### 🛍️ Customer Features
- **Colorful Modern UI** - Vibrant purple, pink, and amber color palette with gradient effects
- **Highly Animated** - Floating elements, pulse glow, gradient animations, and smooth transitions
- **Product Catalog** - Browse products by categories with advanced filtering
- **Product Search** - Real-time search with suggestions
- **Product Details** - Image gallery with Swiper slider, reviews, and related products
- **Shopping Cart** - Add, update, and remove items with quantity controls
- **Wishlist** - Save favorite items for later
- **Checkout** - Multi-payment methods (QR Code, UPI, Bank Transfer)
- **Order Tracking** - Track order status with timeline
- **Coupon System** - Apply discount coupons at checkout
- **Customer Reviews** - Rate and review products
- **Blog** - Fashion tips, style guides, and news
- **Bulk Order Enquiry** - Wholesale pricing requests
- **Newsletter Subscription** - Stay updated with offers

### 👨‍💼 Admin Features
- **Dashboard** - Analytics and statistics
- **Product Management** - CRUD operations with inventory tracking
- **Category Management** - Organize products by categories
- **Order Management** - Process and track orders
- **Payment Verification** - Verify QR/UPI/Bank payments
- **User Management** - Manage customers and staff
- **Coupon Management** - Create and manage discount coupons
- **Blog Management** - Create and manage blog posts
- **Inventory Management** - Track stock levels
- **Reports** - Export sales and inventory reports
- **Settings** - Configure site settings, payment details, and more

### 🔒 Security Features
- Laravel Fortify authentication
- Passkey support
- Role-based access control (Admin, Staff, Customer)
- CSRF protection
- Secure password hashing

## 🚀 Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Tailwind CSS 4, Alpine.js, Swiper.js
- **Database:** MySQL / SQLite / PostgreSQL
- **Authentication:** Laravel Fortify with Passkey support
- **Build Tool:** Vite

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL / SQLite / PostgreSQL

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/clothing-cart.git
cd clothing-cart
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Edit the `.env` file and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clothingcart
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate --seed
```

### 6. Build Frontend Assets
```bash
npm run build
```

### 7. Start the Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🔑 Default Admin Credentials

After running the seeder, use these credentials to login:

- **Email:** `admin@clothingcart.com`
- **Password:** `Admin@123`

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   └── ...             # Frontend controllers
│   │   └── View/Composers/     # View composers
│   ├── Livewire/               # Livewire components
│   ├── Models/                 # Eloquent models
│   ├── Policies/               # Authorization policies
│   ├── Providers/              # Service providers
│   └── Services/               # Business logic services
├── config/                     # Configuration files
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/                     # Public assets
├── resources/
│   ├── css/                    # Tailwind CSS styles
│   ├── js/                     # JavaScript files
│   └── views/                  # Blade templates
│       ├── admin/              # Admin views
│       ├── layouts/            # Layout templates
│       ├── pages/              # Frontend pages
│       └── partials/           # Reusable partials
├── routes/                     # Route definitions
└── tests/                      # Automated tests
```

## 🎨 Design Features

- **Vibrant Color Scheme** - Purple, pink, and amber gradients
- **Modern Animations** - Floating elements, pulse glow effects, gradient animations
- **Playfair Display Font** - Serif typography for headings
- **Responsive Design** - Mobile-first approach
- **Product Hover Effects** - Quick add to cart on hover with zoom
- **Category Cards** - Beautiful image cards with gradient overlays
- **Smooth Interactions** - Hover lift, glow, and scale effects

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📧 Contact

For support or inquiries, please contact:
- **Email:** info@clothingcart.com
- **Website:** [clothingcart.com](https://clothingcart.com)
