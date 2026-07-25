<?php $__env->startSection('title', 'Order #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Home</a>
        <span class="separator">/</span>
        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
        <span class="separator">/</span>
        <a href="<?php echo e(route('orders')); ?>">Orders</a>
        <span class="separator">/</span>
        <span class="current">#<?php echo e($order->order_number); ?></span>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Order #<?php echo e($order->order_number); ?></h1>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            <?php echo e($order->status === 'delivered' ? 'bg-green-100 text-green-800' : ''); ?>

            <?php echo e($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>

            <?php echo e(!in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : ''); ?>">
            <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

        </span>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-3">Shipping Address</h3>
            <p class="text-sm text-gray-600"><?php echo e($order->shipping_name); ?></p>
            <p class="text-sm text-gray-600"><?php echo e($order->shipping_phone); ?></p>
            <p class="text-sm text-gray-600"><?php echo e($order->shipping_address); ?></p>
            <p class="text-sm text-gray-600"><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> - <?php echo e($order->shipping_pincode); ?></p>
        </div>
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-3">Order Details</h3>
            <p class="text-sm text-gray-600">Order Date: <?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
            <p class="text-sm text-gray-600">Payment Method: UPI / Bank Transfer</p>
            <p class="text-sm text-gray-600">Items: <?php echo e($order->items->count()); ?></p>
        </div>
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-3">Order Summary</h3>
            <div class="space-y-1 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>₹<?php echo e(number_format($order->subtotal, 2)); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->discount > 0): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount</span>
                        <span class="text-success">-₹<?php echo e(number_format($order->discount, 2)); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="flex justify-between font-bold text-lg pt-2 border-t">
                    <span>Total</span>
                    <span class="text-primary">₹<?php echo e(number_format($order->total, 2)); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-6 mb-6">
        <h3 class="font-semibold text-primary mb-4">Order Items</h3>
        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                    <div class="w-16 h-16 bg-gray-50 rounded-lg flex items-center justify-center shrink-0">
                        <span class="text-2xl">📦</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-primary"><?php echo e($item->product->name); ?></h4>
                        <p class="text-sm text-gray-500">SKU: <?php echo e($item->product->sku ?? 'N/A'); ?></p>
                        <p class="text-sm text-gray-600">Qty: <?php echo e($item->quantity); ?> × ₹<?php echo e(number_format($item->unit_price, 2)); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-primary">₹<?php echo e(number_format($item->subtotal, 2)); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'delivered'): ?>
                            <?php
                                $existingReview = $item->product->reviews->where('user_id', auth()->id())->where('order_id', $order->id)->first();
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$existingReview): ?>
                                <button onclick="openReviewModal(<?php echo e($order->id); ?>, <?php echo e($item->id); ?>, '<?php echo e($item->product->name); ?>')" class="text-sm text-secondary hover:underline mt-2 inline-block">
                                    Write a Review
                                </button>
                            <?php else: ?>
                                <span class="text-sm text-success mt-2 inline-block">✓ Reviewed</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'pending_payment_verification'): ?>
    <div class="card p-6 mb-6 border-l-4 border-yellow-400">
        <h3 class="font-semibold text-primary mb-4">Payment Under Verification</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment proof has been submitted and is pending verification by the admin. You will be notified via email once verified.</p>
        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
            <p><strong>UTR / Transaction ID:</strong> <span class="font-medium"><?php echo e($order->payment?->utr_number ?? 'N/A'); ?></span></p>
            <p><strong>Payment Method:</strong> <span class="font-medium capitalize"><?php echo e(str_replace('_', ' ', $order->payment_method ?? 'N/A')); ?></span></p>
            <p><strong>Amount:</strong> <span class="font-medium">₹<?php echo e(number_format($order->total, 2)); ?></span></p>
            <p><strong>Status:</strong> <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending Verification</span></p>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'pending_payment' || ($order->payment && $order->payment->status === 'rejected')): ?>
    <div class="card p-6 mb-6 border-l-4 border-red-400">
        <h3 class="font-semibold text-primary mb-4">Payment Required</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment was rejected or not completed. Please submit a new payment proof.</p>
        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
            <p><strong>Total Amount:</strong> ₹<?php echo e(number_format($order->total, 2)); ?></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment && $order->payment->rejection_reason): ?>
                <p class="text-red-600"><strong>Rejection Reason:</strong> <?php echo e($order->payment->rejection_reason); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <a href="<?php echo e(route('payment.form', $order)); ?>" class="btn-primary mt-4 inline-block">Re-submit Payment Proof</a>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment_status === 'paid' && $order->invoice_number): ?>
    <div class="card p-6 mb-6 border-l-4 border-green-400">
        <h3 class="font-semibold text-primary mb-4">GST Invoice</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment has been verified. Invoice <strong><?php echo e($order->invoice_number); ?></strong> is ready.</p>
        <div class="flex gap-3">
            <a href="<?php echo e(route('invoice.view', $order)); ?>" class="btn-primary inline-block" target="_blank">View Invoice (PDF)</a>
            <a href="<?php echo e(route('invoice.download', $order)); ?>" class="btn-outline inline-block">Download Invoice (PDF)</a>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'delivered'): ?>
    <div class="card p-6 mb-6 border-l-4 border-secondary">
        <h3 class="font-semibold text-primary mb-4">Review Your Products</h3>
        <p class="text-sm text-gray-600 mb-4">Share your experience with these products to help other customers.</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $existingReview = $item->product->reviews->where('user_id', auth()->id())->where('order_id', $order->id)->first();
            ?>
            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center shrink-0">
                        <span class="text-xl">📦</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-primary text-sm"><?php echo e($item->product->name); ?></h4>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existingReview): ?>
                    <div class="bg-gray-50 rounded-lg p-3 text-sm">
                        <div class="flex items-center gap-1 mb-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <svg class="w-4 h-4 <?php echo e($i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                        <p class="text-gray-600"><?php echo e($existingReview->comment ?? 'No comment'); ?></p>
                        <p class="text-xs text-gray-400 mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existingReview->is_approved): ?>
                                <span class="text-success">✓ Approved</span>
                            <?php else: ?>
                                <span class="text-yellow-600">⏳ Pending approval</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('review.store')); ?>" class="space-y-3">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($item->product_id); ?>">
                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Rating</label>
                            <div class="star-rating flex gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 5; $i >= 1; $i--): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <input type="radio" id="star<?php echo e($item->id); ?>_<?php echo e($i); ?>" name="rating" value="<?php echo e($i); ?>" class="hidden" required>
                                    <label for="star<?php echo e($item->id); ?>_<?php echo e($i); ?>" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 star-label">★</label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <textarea name="comment" rows="2" class="input-field text-sm" placeholder="Share your experience with this product..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary text-sm py-1.5 px-4">Submit Review</button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex gap-4">
        <a href="<?php echo e(route('orders')); ?>" class="btn-outline">Back to Orders</a>
        <a href="<?php echo e(route('shop')); ?>" class="btn-primary">Continue Shopping</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Projects\dr.Rajendra\project 001\spmApp\resources\views/pages/dashboard/order-detail.blade.php ENDPATH**/ ?>