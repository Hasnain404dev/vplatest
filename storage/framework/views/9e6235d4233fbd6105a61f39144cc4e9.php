<?php $__env->startSection('content'); ?>
    <div class="print-header">
        <img src="<?php echo e(asset('backend/assets/imgs/theme/logo.svg')); ?>" alt="Company Logo">
        <h2>Order #<?php echo e($order->order_number); ?></h2>
        <p>Date: <?php echo e($order->created_at->format('M j, Y h:i A')); ?></p>
    </div>

    <div class="print-section">
        <div style="display: flex; justify-content: space-between; margin-bottom: 3mm;">
            <div style="width: 48%;">
                <h3>Customer Information</h3>
                <div class="compact-row"><strong>Name:</strong> <?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?></div>
                <div class="compact-row"><strong>Email:</strong> <?php echo e($order->email); ?></div>
                <div class="compact-row"><strong>Phone:</strong> <?php echo e($order->phone); ?></div>
                <div class="compact-row">
                    <strong>Address:</strong><br>
                    <?php if($order->different_shipping): ?>
                        <?php echo e($order->shipping_address); ?><br>
                        <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_zipcode); ?>

                    <?php else: ?>
                        <?php echo e($order->address); ?><br>
                        <?php echo e($order->city); ?>, <?php echo e($order->state); ?> <?php echo e($order->zipcode); ?>

                    <?php endif; ?>
                </div>
            </div>

            <div style="width: 48%;">
                <h3>Order Information</h3>
                <div class="compact-row"><strong>Status:</strong> <?php echo e(ucfirst($order->status)); ?></div>
                <div class="compact-row"><strong>Payment Method:</strong> <?php echo e($order->payment_method); ?></div>
                <div class="compact-row"><strong>Order Total:</strong> <?php echo e(number_format($order->total_amount, 2)); ?> PKR
                </div>
                <?php if($order->order_notes): ?>
                    <div class="compact-row"><strong>Customer Notes:</strong> <?php echo e($order->order_notes); ?></div>
                <?php endif; ?>
                <?php if($order->admin_notes): ?>
                    <div class="compact-row"><strong>Admin Notes:</strong> <?php echo e($order->admin_notes); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="print-section">
        <h3>Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th width="40%">Product</th>
                    <th width="15%">Price</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($item->product ? $item->product->name : 'Product not found'); ?></strong>
                            <?php if($item->color_name): ?>
                                <br><small>Color: <?php echo e($item->color_name); ?></small>
                            <?php endif; ?>

                            <?php if($item->prescription): ?>
                                <div class="prescription-details">
                                    <strong>Prescription Details:</strong>
                                    <table class="prescription-table">
                                        <tr>
                                            <td width="30%"><strong>Lens Type:</strong></td>
                                            <td><?php echo e($item->prescription->lens_type); ?></td>
                                        </tr>

                                        <?php if($item->prescription->prescription_type == 'upload' && $item->prescription->prescription_image): ?>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Prescription Image:</strong><br>
                                                    <img src="<?php echo e(asset($item->prescription->prescription_image)); ?>"
                                                        style="max-width: 100%; max-height: 50mm; border: 1px solid #ddd; margin-top: 2mm;">
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php if($item->prescription->prescription_type == 'manual'): ?>
                                            <?php
                                                $prescriptionData = json_decode($item->prescription->prescription_data, true);
                                            ?>
                                            <?php if(isset($prescriptionData['od'])): ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Right Eye (OD):</strong>
                                                        SPH: <?php echo e($prescriptionData['od']['sph'] ?? ''); ?> |
                                                        CYL: <?php echo e($prescriptionData['od']['cyl'] ?? ''); ?> |
                                                        AXIS: <?php echo e($prescriptionData['od']['axis'] ?? ''); ?> |
                                                        ADD: <?php echo e($prescriptionData['od']['add'] ?? ''); ?>

                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php if(isset($prescriptionData['os'])): ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Left Eye (OS):</strong>
                                                        SPH: <?php echo e($prescriptionData['os']['sph'] ?? ''); ?> |
                                                        CYL: <?php echo e($prescriptionData['os']['cyl'] ?? ''); ?> |
                                                        AXIS: <?php echo e($prescriptionData['os']['axis'] ?? ''); ?> |
                                                        ADD: <?php echo e($prescriptionData['os']['add'] ?? ''); ?>

                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php if(isset($prescriptionData['pd'])): ?>
                                                <tr>
                                                    <td><strong>PD:</strong></td>
                                                    <td><?php echo e($prescriptionData['pd']); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <?php if($item->lensesPrescription): ?>
                                <div class="prescription-details">
                                    <strong>Lenses Prescription:</strong>
                                    <table class="prescription-table">
                                        <tr>
                                            <td width="30%"><strong>SPH:</strong></td>
                                            <td>
                                                <?php if(isset($item->lensesPrescription->sph_right)): ?>
                                                    Right: <?php echo e($item->lensesPrescription->sph_right); ?><br>
                                                    Left: <?php echo e($item->lensesPrescription->sph_left); ?>

                                                <?php else: ?>
                                                    <?php echo e($item->lensesPrescription->sph); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if(isset($item->lensesPrescription->cyl)): ?>
                                            <tr>
                                                <td><strong>CYL:</strong></td>
                                                <td><?php echo e($item->lensesPrescription->cyl); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if(isset($item->lensesPrescription->axis)): ?>
                                            <tr>
                                                <td><strong>AXIS:</strong></td>
                                                <td><?php echo e($item->lensesPrescription->axis); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(number_format($item->price, 2)); ?> PKR</td>
                        <td><?php echo e($item->quantity); ?></td>
                        <td class="text-right"><?php echo e(number_format($item->total, 2)); ?> PKR</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Grand Total:</th>
                    <th class="text-right"><?php echo e(number_format($order->total_amount, 2)); ?> PKR</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="print-section no-print" style="text-align: center; margin-top: 5mm;">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-secondary">Close</button>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.print', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\orders\print.blade.php ENDPATH**/ ?>