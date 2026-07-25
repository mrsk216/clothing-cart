<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Home</a>
        <span class="separator">/</span>
        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
        <span class="separator">/</span>
        <span class="current">My Orders</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">My Orders</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->count() > 0): ?>
        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-semibold text-primary">Order #<?php echo e($order->order_number); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?php echo e($order->status === 'delivered' ? 'bg-green-100 text-green-800' : ''); ?>

                            <?php echo e($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>

                            <?php echo e(!in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : ''); ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                        </span>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600"><?php echo e($order->items->count()); ?> item(s)</p>
                                <p class="text-lg font-bold text-primary">₹<?php echo e(number_format($order->total, 2)); ?></p>
                            </div>
                            <a href="<?php echo e(route('order.detail', $order->id)); ?>" class="btn-primary text-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <div class="mt-6">
            <?php echo e($orders->links()); ?>

        </div>
    <?php else: ?>
        <div class="text-center py-16">
            <span class="text-5xl mb-4 block">📦</span>
            <h3 class="text-xl font-semibold text-primary mb-2">No orders yet</h3>
            <p class="text-gray-500 mb-6">Start shopping to place your first order</p>
            <a href="<?php echo e(route('shop')); ?>" class="btn-primary">Start Shopping</a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Projects\dr.Rajendra\project 001\spmApp\resources\views/pages/dashboard/orders.blade.php ENDPATH**/ ?>