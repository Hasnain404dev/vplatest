<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <h2 class="content-title">Customers List</h2>
        <div>
            <a href="<?php echo e(route('admin.customers.export')); ?>" class="btn btn-light rounded font-md">Export</a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <form action="<?php echo e(route('admin.customersData')); ?>" method="GET">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="<?php echo e(request('search')); ?>" />
                    </form>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <form action="<?php echo e(route('admin.customersData')); ?>" method="GET" id="statusForm">
                        <select class="form-select" name="status" onchange="document.getElementById('statusForm').submit()">
                            <option value="">All Status</option>
                            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </form>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <form action="<?php echo e(route('admin.customersData')); ?>" method="GET" id="perPageForm">
                        <select class="form-select" name="show" onchange="document.getElementById('perPageForm').submit()">
                            <option value="20" <?php echo e(request('show') == 20 ? 'selected' : ''); ?>>Show 20</option>
                            <option value="30" <?php echo e(request('show') == 30 ? 'selected' : ''); ?>>Show 30</option>
                            <option value="40" <?php echo e(request('show') == 40 ? 'selected' : ''); ?>>Show 40</option>
                        </select>
                    </form>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Orders</th>
                            <th>Registered</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td width="30%">
                                    <a href="<?php echo e(route('admin.customers.detail', $customer->id)); ?>" class="itemside">
                                        
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></h6>
                                            <small class="text-muted">Customer ID: #<?php echo e($customer->id); ?></small>
                                        </div>
                                    </a>
                                </td>
                                <td><?php echo e($customer->email); ?></td>
                                <td><?php echo e($customer->phone); ?></td>
                                <td>
                                    <?php echo e($customer->city); ?>, <?php echo e($customer->country); ?>

                                </td>
                                <td>
                                    <?php
                                        $orderCount = $customer->orders ? $customer->orders->count() : 0;
                                    ?>
                                    <span class="badge rounded-pill <?php echo e($orderCount > 0 ? 'alert-success' : 'alert-warning'); ?>">
                                        <?php echo e($orderCount); ?> orders
                                    </span>
                                </td>
                                <td><?php echo e($customer->created_at->format('d.m.Y')); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.customers.detail', $customer->id)); ?>" class="btn btn-sm btn-brand rounded font-sm">View details</a>
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                            <i class="material-icons md-more_horiz"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?php echo e(route('admin.customers.detail', $customer->id)); ?>">View details</a>
                                            <form action="<?php echo e(route('admin.customers.delete', $customer->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No customers found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- table-responsive.// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        <?php echo e($customers->links()); ?>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\customers\customerData.blade.php ENDPATH**/ ?>