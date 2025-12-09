<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Order List</h2>
            <p>All orders in the system</p>
        </div>
        <div>
            <form action="<?php echo e(route('admin.orders')); ?>" method="GET">
                <input type="text" name="search" placeholder="Search order ID" class="form-control bg-white" value="<?php echo e(request('search')); ?>">
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <form action="<?php echo e(route('admin.orders')); ?>" method="GET">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="<?php echo e(request('search')); ?>">
                    </form>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <form action="<?php echo e(route('admin.orders')); ?>" method="GET" id="statusForm">
                        <select class="form-select" name="status" onchange="document.getElementById('statusForm').submit()">
                            <option value="">All Status</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </form>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <form action="<?php echo e(route('admin.orders')); ?>" method="GET" id="perPageForm">
                        <select class="form-select" name="show" onchange="document.getElementById('perPageForm').submit()">
                            <option value="20" <?php echo e(request('show') == 20 ? 'selected' : ''); ?>>Show 20</option>
                            <option value="30" <?php echo e(request('show') == 30 ? 'selected' : ''); ?>>Show 30</option>
                            <option value="40" <?php echo e(request('show') == 40 ? 'selected' : ''); ?>>Show 40</option>
                        </select>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($order->order_number); ?></td>
                                <td><b><?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?></b></td>
                                <td><?php echo e($order->email); ?></td>
                                <td><?php echo e(number_format($order->total_amount, 2)); ?> PKR</td>
                                <td><?php echo e($order->payment_method); ?></td>
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
                                <td><?php echo e($order->created_at->format('d.m.Y')); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.orders.orderDetail', $order->id)); ?>" class="btn btn-md rounded font-sm">Detail</a>
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                            <i class="material-icons md-more_horiz"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?php echo e(route('admin.orders.orderDetail', $order->id)); ?>">View detail</a>
                                            <form action="<?php echo e(route('admin.orders.delete', $order->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div> <!-- dropdown //end -->
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center">No orders found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div> <!-- table-responsive //end -->
        </div> <!-- card-body end// -->
    </div> <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        <?php echo e($orders->links()); ?>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/backend/orders/index.blade.php ENDPATH**/ ?>