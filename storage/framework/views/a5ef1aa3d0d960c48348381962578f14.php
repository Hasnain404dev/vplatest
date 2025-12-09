<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Customer Detail</h2>
            <p>Customer ID: #<?php echo e($customer->id); ?></p>
        </div>
        
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-xl-8 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->first_name); ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->last_name); ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->email); ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->phone); ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->company_name ?: 'N/A'); ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Registered Date</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->created_at->format('d M Y, h:i A')); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5>Address Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->address ?: 'N/A'); ?></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address 2</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->address2 ?: 'N/A'); ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">City</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->city ?: 'N/A'); ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">State</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->state ?: 'N/A'); ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Zipcode</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->zipcode ?: 'N/A'); ?></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Country</label>
                                    <div class="form-control-plaintext"><?php echo e($customer->country ?: 'N/A'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Orders</span>
                                <span class="text-primary"><?php echo e($customer->orders ? $customer->orders->count() : 0); ?></span>
                            </div>
                            <?php if($customer->orders && $customer->orders->count() > 0): ?>
                                <?php
                                    $totalSpent = $customer->orders->sum('total_amount');
                                    $latestOrder = $customer->orders->sortByDesc('created_at')->first();
                                ?>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Total Spent</span>
                                    <span class="text-primary"><?php echo e(number_format($totalSpent, 2)); ?> PKR</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Latest Order</span>
                                    <span class="text-primary"><?php echo e($latestOrder->created_at->format('d M Y')); ?></span>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">No orders found for this customer.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Order History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $customer->orders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($order->order_number); ?></td>
                                        <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                                        <td><?php echo e(number_format($order->total_amount, 2)); ?> PKR</td>
                                        <td>
                                            <?php
                                                $statusClass = [
                                                    'pending' => 'alert-warning',
                                                    'processing' => 'alert-info',
                                                    'completed' => 'alert-success',
                                                    'cancelled' => 'alert-danger',
                                                ][$order->status ?? 'pending'];
                                            ?>
                                            <span class="badge rounded-pill <?php echo e($statusClass); ?>">
                                                <?php echo e(ucfirst($order->status ?? 'pending')); ?>

                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?php echo e(route('admin.orders.orderDetail', $order->id)); ?>" class="btn btn-sm btn-light">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/backend/customers/detail.blade.php ENDPATH**/ ?>