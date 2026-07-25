<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
        $defaultDesc = \App\Models\Setting::where('key', 'meta_description')->value('value')
            ?: 'Buy paper products, stamp pads, rubber seals and screen printing materials online. Fast delivery across India.';
        $defaultKeywords = \App\Models\Setting::where('key', 'meta_keywords')->value('value')
            ?: 'paper, stamp pad, rubber seal, screen printing, wholesale stationery';
        $pageTitle = trim($__env->yieldContent('title', config('app.name', 'SPM Enterprise')));
        $pageDesc = trim($__env->yieldContent('meta_description', $defaultDesc));
        $canonical = trim($__env->yieldContent('canonical', url()->current()));
    ?>
    <meta name="description" content="<?php echo e($pageDesc); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords', $defaultKeywords); ?>">
    <meta name="robots" content="<?php echo $__env->yieldContent('meta_robots', 'index, follow'); ?>">
    <link rel="canonical" href="<?php echo e($canonical); ?>">

    <meta property="og:type" content="<?php echo $__env->yieldContent('og_type', 'website'); ?>">
    <meta property="og:site_name" content="<?php echo e(config('app.name', 'SPM Enterprise')); ?>">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDesc); ?>">
    <meta property="og:url" content="<?php echo e($canonical); ?>">
    <?php if (! empty(trim($__env->yieldContent('og_image')))): ?>
        <meta property="og:image" content="<?php echo $__env->yieldContent('og_image'); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($pageDesc); ?>">

    <title><?php echo e($pageTitle); ?></title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <?php echo app('Illuminate\Foundation\Vite')->fonts(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('head'); ?>
    <?php echo $__env->yieldPushContent('structured_data'); ?>
</head>
<body class="font-sans antialiased bg-surface text-text-primary">
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.whatsapp-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH F:\Projects\dr.Rajendra\project 001\spmApp\resources\views/layouts/guest.blade.php ENDPATH**/ ?>