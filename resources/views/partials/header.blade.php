<header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
    <!-- Top bar -->
    <div class="bg-primary text-white text-xs py-1.5">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <span>📞 Call us: <a href="tel:+919876543210" class="hover:text-secondary transition-colors">+91-9876543210</a></span>
            <span class="hidden sm:block">✉️ <a href="mailto:info@spmapp.com" class="hover:text-secondary transition-colors">info@spmapp.com</a></span>
        </div>
    </div>

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">SPM</span>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-primary leading-tight">SPM Enterprise</h1>
                    <p class="text-xs text-gray-500">Paper, Stamp Pad, Rubber Seal</p>
                </div>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 max-w-xl hidden md:block">
                <div class="search-box">
                    <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Search products..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-full focus:border-secondary focus:ring-2 focus:ring-secondary/20 focus:outline-none" id="search-input">
                    <div class="search-suggestions" id="search-suggestions">
                        <div class="p-3 text-sm text-gray-500">Start typing to search products...</div>
                    </div>
                </div>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center gap-3">
                <!-- Wishlist -->
                <a href="{{ route('wishlist') }}" class="relative p-2 text-gray-600 hover:text-secondary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="relative p-2 text-gray-600 hover:text-secondary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <span class="cart-badge" id="cart-count">0</span>
                </a>

                <!-- User Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 p-2 text-gray-600 hover:text-secondary transition-colors">
                            <div class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center">
                                <span class="text-sm font-semibold text-secondary">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden lg:block text-sm font-medium">{{ Auth::user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            @if(Auth::user()->hasStaffAccess())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Dashboard</a>
                            <a href="{{ route('orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Orders</a>
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Profile</a>
                            <hr class="my-2 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-primary text-sm px-4 py-2">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary-dark text-sm px-4 py-2 hidden sm:inline-flex">
                        Register
                    </a>
                @endauth

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2 text-gray-600" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="hidden md:block border-t border-gray-100 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <ul class="flex items-center gap-1">
                <li>
                    <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-secondary hover:bg-white rounded-t-lg transition-colors">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('shop') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-secondary hover:bg-white rounded-t-lg transition-colors">
                        All Products
                    </a>
                </li>
                <li class="relative group">
                    <a href="#" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-secondary hover:bg-white rounded-t-lg transition-colors flex items-center gap-1">
                        Categories
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    <div class="absolute left-0 mt-0 w-56 bg-white rounded-lg shadow-lg border border-gray-100 py-2 hidden group-hover:block z-50">
                        @foreach($categories as $category)
                            <div class="relative group/sub">
                                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-secondary">
                                    {{ $category->name }}
                                </a>
                                @if($category->children->count() > 0)
                                    <div class="absolute left-full top-0 w-56 bg-white rounded-lg shadow-lg border border-gray-100 py-2 hidden group-hover/sub:block">
                                        @foreach($category->children as $child)
                                            <a href="{{ route('shop', ['category' => $child->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-secondary">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-secondary hover:bg-white rounded-t-lg transition-colors">
                        About
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-secondary hover:bg-white rounded-t-lg transition-colors">
                        Blog
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-secondary hover:bg-white rounded-t-lg transition-colors">
                        Contact
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3">
            <div class="search-box mb-3">
                <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:border-secondary focus:ring-2 focus:ring-secondary/20 focus:outline-none text-sm">
            </div>
            <ul class="space-y-1">
                <li><a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Home</a></li>
                <li><a href="{{ route('shop') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">All Products</a></li>
                @foreach($categories as $category)
                    <li><a href="{{ route('shop', ['category' => $category->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">{{ $category->name }}</a></li>
                @endforeach
                <li><a href="{{ route('about') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">About</a></li>
                <li><a href="{{ route('blog') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Blog</a></li>
                <li><a href="{{ route('contact') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Contact</a></li>
            </ul>
        </div>
    </div>
</header>
