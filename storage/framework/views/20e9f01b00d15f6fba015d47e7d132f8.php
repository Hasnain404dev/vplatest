<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Payments</h2>
            <p>All submitted payments with proof and COD</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Search by order # or transaction id">
                </div>
                <div class="col-md-3">
                    <select name="method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="cash_on_delivery" <?php echo e(request('method')==='cash_on_delivery' ? 'selected' : ''); ?>>Cash on Delivery</option>
                        <option value="jazzcash" <?php echo e(request('method')==='jazzcash' ? 'selected' : ''); ?>>JazzCash</option>
                        <option value="meezan_bank" <?php echo e(request('method')==='meezan_bank' ? 'selected' : ''); ?>>Meezan Bank</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php echo e(request('status')==='pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="verified" <?php echo e(request('status')==='verified' ? 'selected' : ''); ?>>Verified</option>
                        <option value="rejected" <?php echo e(request('status')==='rejected' ? 'selected' : ''); ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order #</th>
                            <th>Method</th>
                            <!--<th>Transaction ID</th>-->
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($payment->id); ?></td>
                                <td>
                                    <?php if($payment->order): ?>
                                        <a href="<?php echo e(route('admin.orders.orderDetail', $payment->order->id)); ?>"><?php echo e($payment->order->order_number); ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($payment->method_display); ?></td>
                                <!--<td><?php echo e($payment->transaction_id ?? '-'); ?></td>-->
                                <td>
                                    <?php $status = $payment->getRawOriginal('status') ?? 'pending'; ?>
                                    <span class="badge rounded-pill alert-<?php echo e($status==='verified' ? 'success' : ($status==='rejected' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($status)); ?></span>
                                </td>
                                <td><?php echo e($payment->created_at->format('Y-m-d H:i')); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('admin.payments.show', $payment)); ?>">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No payments found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($payments->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\payments\index.blade.php ENDPATH**/ ?>