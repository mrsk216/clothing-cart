<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - <?php echo e($siteName()); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar backdrop overlay -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <aside class="admin-sidebar flex flex-col overflow-hidden" id="sidebar">
            <div class="p-4 border-b border-white/10 flex items-center justify-between shrink-0">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white font-serif font-bold">CC</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-white">Admin Panel</h2>
                    </div>
                </a>
                <button class="lg:hidden p-1.5 text-white/60 hover:text-white hover:bg-white/10 rounded-lg transition-colors" onclick="closeSidebar()" title="Close sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="p-4 space-y-1 overflow-y-auto flex-1">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.products')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.products*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Products</span>
                </a>
                <a href="<?php echo e(route('admin.categories')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.categories*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span>Categories</span>
                </a>
                <a href="<?php echo e(route('admin.orders')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.orders*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Orders</span>
                </a>
                <a href="<?php echo e(route('admin.payment-verification')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.payment*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Payment Verification</span>
                </a>
                <a href="<?php echo e(route('admin.users')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.users*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Users</span>
                </a>
                <a href="<?php echo e(route('admin.coupons')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.coupons*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    <span>Coupons</span>
                </a>
                <a href="<?php echo e(route('admin.blog')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.blog*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9a2 2 0 00-2 2v1m-4 7h6"/></svg>
                    <span>Blog</span>
                </a>
                <a href="<?php echo e(route('admin.messages')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.messages*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Messages</span>
                </a>
                <a href="<?php echo e(route('admin.reviews')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.reviews*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <span>Reviews</span>
                </a>
                <a href="<?php echo e(route('admin.inventory')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.inventory*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Inventory</span>
                </a>
                <a href="<?php echo e(route('admin.notifications')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.notifications*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span>Notifications</span>
                </a>
                <a href="<?php echo e(route('admin.settings')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white hover:bg-white/10 transition-colors <?php echo e(request()->routeIs('admin.settings*') ? 'bg-white/10' : ''); ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-content flex-1">
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <button class="lg:hidden p-2 text-gray-600" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="ml-auto flex items-center gap-4">
                        <a href="<?php echo e(route('home')); ?>" class="text-sm text-secondary hover:underline inline">View Site</a>
                        <span class="text-sm text-gray-600"><?php echo e(auth()->user()->name); ?></span>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-sm text-red-600 hover:text-red-700">Logout</button>
                        </form>
                    </div>
                </div>
            </header>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('open');
            backdrop.classList.toggle('hidden');
        }
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.remove('open');
            backdrop.classList.add('hidden');
        }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH F:\Projects\dr.Rajendra\project 001\spmApp\resources\views/admin/layout.blade.php ENDPATH**/ ?>