<?php $__env->startSection('styles'); ?>
    <style>
        .prescription-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #0d6efd;
            margin-top: 15px !important;
            font-size: 1rem;
        }

        .prescription-details h6 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0d6efd;
        }

        .prescription-details table {
            font-size: 1rem;
        }

        .prescription-details table th {
            background-color: #e9ecef;
            font-weight: 600;
        }

        .prescription-details table th,
        .prescription-details table td {
            padding: 0.5rem;
            vertical-align: middle;
        }

        /* Make sure the prescription details span the full width on mobile */
        @media only screen and (max-width: 768px) {
            .prescription-details .row>div {
                margin-bottom: 10px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Order detail</h2>
            <p>Details for Order ID: <?php echo e($order->order_number); ?></p>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                    <span>
                        <i class="material-icons md-calendar_today"></i>
                        <b><?php echo e($order->created_at->format('D, M d, Y, h:ia')); ?></b>
                    </span> <br>
                    <small class="text-muted">Order ID: <?php echo e($order->order_number); ?></small>
                </div>
                <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                    <form action="<?php echo e(route('admin.orders.update', $order->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <select class="form-select d-inline-block mb-lg-0 mb-15 mw-200" name="status">
                            <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Processing
                            </option>
                            <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>Completed
                            </option>
                            <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <a href="<?php echo e(route('admin.orders.print', $order->id)); ?>" class="btn btn-secondary ms-2" target="_blank">
                        <i class="icon material-icons md-print"></i> Print Order
                    </a>
                </div>
            </div>
        </header> <!-- card-header end// -->
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Customer</h6>
                            <p class="mb-1">
                                <?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?> <br>
                                <?php echo e($order->email); ?> <br>
                                <?php echo e($order->phone); ?>

                            </p>
                            <?php if($order->user_id): ?>
                                <a href="<?php echo e(route('admin.customers.detail', $order->user_id)); ?>">View profile</a>
                            <?php endif; ?>
                        </div>
                    </article>
                </div> <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-local_shipping"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Order info</h6>
                            <p class="mb-1">
                                Payment Method: <?php echo e($order->payment_method); ?> <br>
                                Status: <?php echo e(ucfirst($order->status)); ?>

                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-place"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Deliver to</h6>
                            <p class="mb-1">
                                <?php if($order->different_shipping): ?>
                                    <?php echo e($order->shipping_address); ?>,
                                    <?php echo e($order->shipping_address2 ? $order->shipping_address2 . ', ' : ''); ?>

                                    <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?>

                                    <?php echo e($order->shipping_zipcode); ?><br>
                                    <?php echo e($order->shipping_country); ?>

                                <?php else: ?>
                                    <?php echo e($order->address); ?>, <?php echo e($order->address2 ? $order->address2 . ', ' : ''); ?>

                                    <?php echo e($order->city); ?>, <?php echo e($order->state); ?> <?php echo e($order->zipcode); ?><br>
                                    <?php echo e($order->country); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
            </div> <!-- row // -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="40%">Product</th>
                                    <th width="20%">Product Price</th>
                                    <th width="20%">Product Color</th>
                                    <th width="20%">Unit Price</th>

                                    <th width="20%">Quantity</th>
                                    <th width="20%" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a class="itemside"
                                                href="<?php echo e(route('admin.product.edit', $item->product_id)); ?>">
                                                <div class="left">
                                                    <?php if($item->product && $item->product->main_image): ?>
                                                        <img src="<?php echo e(asset('uploads/products/' . $item->product->main_image)); ?>"
                                                            width="100%" height="auto" class="img-xs"
                                                            alt="<?php echo e($item->product->name); ?>">
                                                    <?php else: ?>
                                                        <div class="img-xs bg-secondary rounded"
                                                            style="width: 40px; height: 40px;"></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="info">
                                                    <?php echo e($item->product ? $item->product->name : 'Product not found'); ?>

                                                </div>
                                            </a>
                                            <?php if($item->prescription): ?>
                                                <div class="mt-3 prescription-details w-100">
                                                    <h6 class="mb-3">Prescription Details:</h6>
                                                    <div>
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th width="30%">Lens Type:</th>
                                                                    <td colspan="2"><?php echo e($item->prescription->lens_type); ?>

                                                                    </td>
                                                                </tr>
                                                                <?php if($item->prescription->lens_feature): ?>
                                                                    <tr>
                                                                        <th>Lens Feature:</th>
                                                                        <td colspan="2">
                                                                            <?php echo e($item->prescription->lens_feature); ?></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if($item->prescription->lens_option): ?>
                                                                    <tr>
                                                                        <th>Lens Option:</th>
                                                                        <td colspan="2">
                                                                            <?php echo e($item->prescription->lens_option); ?></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <tr>
                                                                    <th>Lens Price:</th>
                                                                    <td colspan="2">
                                                                        <?php echo e(number_format($item->prescription->lens_price, 2)); ?>

                                                                        PKR</td>
                                                                </tr>

                                                                <?php if($item->prescription->prescription_type == 'manual'): ?>
                                                                    <?php
                                                                        $prescriptionData = json_decode(
                                                                            $item->prescription->prescription_data,
                                                                            true,
                                                                        );
                                                                    ?>

                                                                    <?php if($item->prescription->lens_type != 'Non-Prescription'): ?>
                                                                        <?php if(isset($prescriptionData['od']) || isset($prescriptionData['os'])): ?>
                                                                            <tr>
                                                                                <th></th>
                                                                                <th>Right Eye (OD)</th>
                                                                                <th>Left Eye (OS)</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>SPH</th>
                                                                                <td><?php echo e($prescriptionData['od']['sph'] ?? 'N/A'); ?>

                                                                                </td>
                                                                                <td><?php echo e($prescriptionData['os']['sph'] ?? 'N/A'); ?>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>CYL</th>
                                                                                <td><?php echo e($prescriptionData['od']['cyl'] ?? 'N/A'); ?>

                                                                                </td>
                                                                                <td><?php echo e($prescriptionData['os']['cyl'] ?? 'N/A'); ?>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>AXIS</th>
                                                                                <td><?php echo e($prescriptionData['od']['axis'] ?? 'N/A'); ?>

                                                                                </td>
                                                                                <td><?php echo e($prescriptionData['os']['axis'] ?? 'N/A'); ?>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>ADD</th>
                                                                                <td><?php echo e($prescriptionData['od']['add'] ?? 'N/A'); ?>

                                                                                </td>
                                                                                <td><?php echo e($prescriptionData['os']['add'] ?? 'N/A'); ?>

                                                                                </td>
                                                                            </tr>
                                                                        <?php endif; ?>

                                                                        <?php if(isset($prescriptionData['pd']) && $prescriptionData['pd']): ?>
                                                                            <tr>
                                                                                <th>PD (Pupillary Distance):</th>
                                                                                <td colspan="2">
                                                                                    <?php echo e($prescriptionData['pd']); ?></td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                        <?php if(isset($prescriptionData['pdDual']) && ($prescriptionData['pdDual']['right'] || $prescriptionData['pdDual']['left'])): ?>
                                                                            <tr>
                                                                                <th>Dual PD:</th>
                                                                                <td><?php echo e($prescriptionData['pdDual']['right'] ?? 'N/A'); ?>

                                                                                </td>
                                                                                <td><?php echo e($prescriptionData['pdDual']['left'] ?? 'N/A'); ?>

                                                                                </td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if($item->prescription->prescription_type == 'upload'): ?>
                                                                    <tr>
                                                                        <th>Prescription Image:</th>
                                                                        <td colspan="2">
                                                                            <img src="<?php echo e(asset($item->prescription->prescription_image)); ?>"
                                                                                alt="Prescription Image" class="img-fluid"
                                                                                width="100%" height="auto"
                                                                                style="">
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if($item->lensesPrescription): ?>
                                                <div class="mt-3 prescription-details w-100">
                                                    <h6 class="mb-3">Lenses Prescription Details:</h6>
                                                    <div>
                                                        <table class="table table-bordered">
                                                         <tbody>
                                                                <?php if(isset($item->lensesPrescription->sph_right) || isset($item->lensesPrescription->sph_left)): ?>
                                                                    <?php if(isset($item->lensesPrescription->sph_right)): ?>
                                                                        <tr>
                                                                            <th width="30%">SPH Right:</th>
                                                                            <td><?php echo e($item->lensesPrescription->sph_right); ?></td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    <?php if(isset($item->lensesPrescription->sph_left)): ?>
                                                                        <tr>
                                                                            <th>SPH Left:</th>
                                                                            <td><?php echo e($item->lensesPrescription->sph_left); ?></td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php elseif(isset($item->lensesPrescription->sph)): ?>
                                                                    <tr>
                                                                        <th>SPH:</th>
                                                                        <td><?php echo e($item->lensesPrescription->sph); ?></td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                                <?php if(isset($item->lensesPrescription->cyl)): ?>
                                                                    <tr>
                                                                        <th>CYL:</th>
                                                                        <td><?php echo e($item->lensesPrescription->cyl); ?></td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                                <?php if(isset($item->lensesPrescription->axis)): ?>
                                                                    <tr>
                                                                        <th>AXIS:</th>
                                                                        <td><?php echo e($item->lensesPrescription->axis); ?></td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                                <tr>
                                                                    <th>Quantity:</th>
                                                                    <td><?php echo e($item->lensesPrescription->quantity ?? 1); ?></td>
                                                                </tr>
                                                                
                                                                <?php if(isset($item->lensesPrescription->total_price)): ?>
                                                                    <tr>
                                                                        <th>Total Price:</th>
                                                                        <td><?php echo e(number_format($item->lensesPrescription->total_price, 2)); ?> PKR</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($item->product && $item->product->discountprice): ?>
                                                <?php echo e(number_format($item->product->discountprice, 2)); ?> PKR
                                                <small
                                                    class="text-muted text-decoration-line-through"><?php echo e(number_format($item->product->price, 2)); ?>

                                                    PKR</small>
                                            <?php else: ?>
                                                <?php echo e(number_format($item->product->price ?? 0, 2)); ?> PKR
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($item->color_name): ?>
                                                <span class="badge bg-primary"><?php echo e($item->color_name); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td> <?php echo e($item->quantity); ?> </td>
                                        <td class="text-end"> <?php echo e(number_format($item->total, 2)); ?> PKR </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="4">
                                        <article class="float-end">
                                            <dl class="dlist">
                                                <dt>Subtotal:</dt>
                                                <dd><?php echo e(number_format($order->total_amount, 2)); ?> PKR</dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Grand total:</dt>
                                                <dd> <b class="h5"><?php echo e(number_format($order->total_amount, 2)); ?> PKR</b>
                                                </dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt class="text-muted">Status:</dt>
                                                <dd>
                                                    <?php
                                                        $statusClass = [
                                                            'pending' => 'alert-warning text-warning',
                                                            'processing' => 'alert-info text-info',
                                                            'completed' => 'alert-success text-success',
                                                            'cancelled' => 'alert-danger text-danger',
                                                        ][$order->status ?? 'pending'];
                                                    ?>
                                                    <span class="badge rounded-pill <?php echo e($statusClass); ?>">
                                                        <?php echo e(ucfirst($order->status)); ?>

                                                    </span>
                                                </dd>
                                            </dl>
                                        </article>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- table-responsive// -->
                </div> <!-- col// -->
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                    <div class="box shadow-sm bg-light">
                        <h6 class="mb-15">Payment info</h6>
                        <p>
                            Payment Method: <?php echo e($order->payment_method); ?> <br>
                            <?php if($order->company_name): ?>
                                Company: <?php echo e($order->company_name); ?> <br>
                            <?php endif; ?>
                            Phone: <?php echo e($order->phone); ?>

                        </p>
                    </div>
                    <?php if($order->order_notes): ?>
                        <div class="h-25 pt-4">
                            <div class="mb-3">
                                <label>Order Notes</label>
                                <div class="form-control bg-light"><?php echo e($order->order_notes); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="h-25 pt-4">
                        <div class="mb-3">
                            <label>Admin Notes</label>
                            <form action="<?php echo e(route('admin.orders.update', $order->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <textarea class="form-control" name="admin_notes" placeholder="Add admin notes here"><?php echo e($order->admin_notes ?? ''); ?></textarea>
                                <button type="submit" class="btn btn-primary mt-3">Save Notes</button>
                            </form>
                        </div>
                    </div>
                </div> <!-- col// -->
            </div>
        </div> <!-- card-body end// -->
    </div> <!-- card end// -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\orders\orderDetail.blade.php ENDPATH**/ ?>