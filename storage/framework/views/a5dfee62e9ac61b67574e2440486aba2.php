<?php $__env->startSection('title', 'Order #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Order #<?php echo e($order->order_number); ?></h1>
        <a href="<?php echo e(route('admin.orders')); ?>" class="btn-outline">Back to Orders</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Order Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Number</p>
                        <p class="font-medium text-primary">#<?php echo e($order->order_number); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium text-primary"><?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php echo e($order->status === 'delivered' ? 'bg-green-100 text-green-800' : ''); ?>

                            <?php echo e($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>

                            <?php echo e(!in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : ''); ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="font-medium text-primary text-lg">₹<?php echo e(number_format($order->total, 2)); ?></p>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Order Items</h3>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">📦</span>
                                </div>
                                <div>
                                    <p class="font-medium text-primary"><?php echo e($item->product->name ?? 'Product'); ?></p>
                                    <p class="text-sm text-gray-500">Qty: <?php echo e($item->quantity); ?> × ₹<?php echo e(number_format($item->unit_price, 2)); ?></p>
                                </div>
                            </div>
                            <p class="font-medium text-primary">₹<?php echo e(number_format($item->subtotal, 2)); ?></p>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Customer Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium text-primary"><?php echo e($order->user?->name ?? 'Guest'); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-primary"><?php echo e($order->user?->email ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-primary"><?php echo e($order->shipping_phone ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Shipping Address</h3>
                <p class="text-sm text-gray-700"><?php echo e($order->shipping_address ?? 'N/A'); ?></p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment): ?>
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Payment Information</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-500">UTR Number</p>
                        <p class="font-medium font-mono"><?php echo e($order->payment->utr_number ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Amount</p>
                        <p class="font-medium">₹<?php echo e(number_format($order->payment->amount, 2)); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Method</p>
                        <p class="font-medium capitalize"><?php echo e(str_replace('_', ' ', $order->payment->payment_method ?? 'N/A')); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php echo e($order->payment->status === 'approved' ? 'bg-green-100 text-green-800' : ''); ?>

                            <?php echo e($order->payment->status === 'rejected' ? 'bg-red-100 text-red-800' : ''); ?>

                            <?php echo e($order->payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>">
                            <?php echo e(ucfirst($order->payment->status)); ?>

                        </span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment->screenshot_path): ?>
                        <div>
                            <p class="text-gray-500">Screenshot</p>
                            <a href="<?php echo e(asset('storage/' . $order->payment->screenshot_path)); ?>" target="_blank" class="text-secondary hover:underline">View Payment Proof</a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment->rejection_reason): ?>
                        <div>
                            <p class="text-gray-500">Rejection Reason</p>
                            <p class="text-red-600"><?php echo e($order->payment->rejection_reason); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Update Status</h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                    <div class="mb-3 p-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm"><?php echo e(session('error')); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="mb-3 p-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm"><?php echo e(session('success')); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment_status !== 'paid'): ?>
                    <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg p-2 mb-3">
                        Payment not approved yet. Processing / shipping statuses are blocked until payment is verified.
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <form method="POST" action="<?php echo e(route('admin.orders.status', $order->id)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <select name="status" class="input-field mb-3">
                        <option value="pending_payment_verification" <?php echo e($order->status === 'pending_payment_verification' ? 'selected' : ''); ?>>Pending Payment Verification</option>
                        <option value="pending_payment" <?php echo e($order->status === 'pending_payment' ? 'selected' : ''); ?>>Pending Payment</option>
                        <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?> <?php echo e($order->payment_status !== 'paid' ? 'disabled' : ''); ?>>Processing</option>
                        <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?> <?php echo e($order->payment_status !== 'paid' ? 'disabled' : ''); ?>>Shipped</option>
                        <option value="delivered" <?php echo e($order->status === 'delivered' ? 'selected' : ''); ?> <?php echo e($order->payment_status !== 'paid' ? 'disabled' : ''); ?>>Delivered</option>
                        <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn-primary w-full">Update Status</button>
                </form>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment && $order->payment->verificationLogs?->count()): ?>
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Verification Logs</h3>
                <div class="space-y-2 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->payment->verificationLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="p-2 bg-gray-50 rounded">
                            <p class="font-medium capitalize"><?php echo e($log->action); ?> by <?php echo e($log->admin?->name ?? 'Admin'); ?></p>
                            <p class="text-gray-500 text-xs"><?php echo e($log->created_at->format('d M Y, h:i A')); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->rejection_reason): ?>
                                <p class="text-red-600"><?php echo e($log->rejection_reason); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Projects\dr.Rajendra\project 001\spmApp\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>