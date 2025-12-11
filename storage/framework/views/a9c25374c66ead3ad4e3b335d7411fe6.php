<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('frontend.home')); ?>" rel="nofollow">Home</a>
                    <span></span> Pages
                    <span></span> Account
                </div>
            </div>
        </div>
        <section class="pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                                href="#dashboard" role="tab" aria-controls="dashboard"
                                                aria-selected="false"><i
                                                    class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                                role="tab" aria-controls="orders" aria-selected="false"><i
                                                    class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                                role="tab" aria-controls="address" aria-selected="true"><i
                                                    class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                                                onclick="event.preventDefault();  document.getElementById('logout-form').submit();"><i
                                                    class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content dashboard-content">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                        aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Hello <?php echo e(auth()->user()->name); ?>!</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Account Information</h6>
                                                        <p>
                                                            <strong>Name:</strong> <?php echo e($customer->first_name ?? ''); ?>

                                                            <?php echo e($customer->last_name ?? ''); ?><br>
                                                            <strong>Email:</strong> <?php echo e(auth()->user()->email); ?><br>
                                                            <strong>Phone:</strong> <?php echo e($customer->phone ?? 'Not provided'); ?>

                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Default Address</h6>
                                                        <?php if($customer): ?>
                                                            <address>
                                                                <?php echo e($customer->address); ?><br>
                                                                <?php if($customer->address2): ?>
                                                                    <?php echo e($customer->address2); ?><br>
                                                                <?php endif; ?>
                                                                <?php echo e($customer->city); ?>, <?php echo e($customer->state); ?><br>
                                                                <?php echo e($customer->zipcode); ?><br>
                                                                <?php echo e($customer->country); ?>

                                                            </address>
                                                        <?php else: ?>
                                                            <p>No address information saved.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <p class="mt-3">From your account dashboard. you can easily check &amp;
                                                    view your <a href="#orders">recent orders</a> and <a href="#">edit
                                                        your account details.</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Your Orders</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order #</th>
                                                                <th>Date</th>
                                                                <th>Items</th>
                                                                <th>Total</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <tr>
                                                                    <td><?php echo e($order->order_number); ?></td>
                                                                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                                                    <td><?php echo e($order->items->sum('quantity')); ?></td>
                                                                    <td><?php echo e(number_format($order->total_amount, 2)); ?></td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-<?php echo e($order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning')); ?>">
                                                                            <?php echo e(ucfirst($order->status)); ?>

                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <tr>
                                                                    <td colspan="6" class="text-center">You have no
                                                                        orders yet.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Billing Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php if($customer): ?>
                                                            <address>
                                                                <strong><?php echo e($customer->first_name); ?>

                                                                    <?php echo e($customer->last_name); ?></strong><br>
                                                                <?php if($customer->company_name): ?>
                                                                    <?php echo e($customer->company_name); ?><br>
                                                                <?php endif; ?>
                                                                <?php echo e($customer->address); ?><br>
                                                                <?php if($customer->address2): ?>
                                                                    <?php echo e($customer->address2); ?><br>
                                                                <?php endif; ?>
                                                                <?php echo e($customer->city); ?>, <?php echo e($customer->state); ?><br>
                                                                <?php echo e($customer->zipcode); ?><br>
                                                                <?php echo e($customer->country); ?><br>
                                                                <strong>Phone:</strong> <?php echo e($customer->phone); ?><br>
                                                                <strong>Email:</strong> <?php echo e(auth()->user()->email); ?>

                                                            </address>
                                                            <a href=""
                                                                class="btn-small">Edit Information</a>
                                                        <?php else: ?>
                                                            <p>No billing information saved.</p>
                                                            <a href=""
                                                                class="btn-small">Add Information</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php if($customer && $customer->shipping_address): ?>
                                                            <address>
                                                                <strong><?php echo e($customer->shipping_first_name ?? $customer->first_name); ?>

                                                                    <?php echo e($customer->shipping_last_name ?? $customer->last_name); ?></strong><br>
                                                                <?php echo e($customer->shipping_address); ?><br>
                                                                <?php if($customer->shipping_address2): ?>
                                                                    <?php echo e($customer->shipping_address2); ?><br>
                                                                <?php endif; ?>
                                                                <?php echo e($customer->shipping_city); ?>,
                                                                <?php echo e($customer->shipping_state); ?><br>
                                                                <?php echo e($customer->shipping_zipcode); ?><br>
                                                                <?php echo e($customer->shipping_country ?? $customer->country); ?>

                                                            </address>
                                                            <a href=""
                                                                class="btn-small">Edit Information</a>
                                                        <?php elseif($customer): ?>
                                                            <p>Same as billing address</p>
                                                            <a href=""
                                                                class="btn-small">Add Different Shipping Address</a>
                                                        <?php else: ?>
                                                            <p>No shipping information saved.</p>
                                                            <a href=""
                                                                class="btn-small">Add Information</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\account.blade.php ENDPATH**/ ?>