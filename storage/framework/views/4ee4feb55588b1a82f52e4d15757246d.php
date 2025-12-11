<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Payment #<?php echo e($payment->id); ?></h2>
            <p>Order: <?php echo e($payment->order?->order_number ?? '-'); ?></p>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Details</h4>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Method</dt>
                        <dd class="col-sm-8"><?php echo e($payment->method_display); ?></dd>

                        <!--<dt class="col-sm-4">Transaction ID</dt>-->
                        <!--<dd class="col-sm-8"><?php echo e($payment->transaction_id ?? '-'); ?></dd>-->

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8"><?php echo e(ucfirst($payment->status ?? 'pending')); ?></dd>

                        <dt class="col-sm-4">Submitted At</dt>
                        <dd class="col-sm-8"><?php echo e($payment->created_at->format('Y-m-d H:i')); ?></dd>

                        <dt class="col-sm-4">Verified At</dt>
                        <dd class="col-sm-8"><?php echo e($payment->verified_at ? $payment->verified_at->format('Y-m-d H:i') : '-'); ?></dd>

                        <dt class="col-sm-4">Admin Notes</dt>
                        <dd class="col-sm-8"><?php echo e($payment->admin_notes ?? '-'); ?></dd>
                    </dl>
                </div>
            </div>

            <?php if($payment->screenshot_url): ?>
                <div class="card mb-4">
                    <div class="card-header"><h4>Payment Screenshot</h4></div>
                    <div class="card-body">
                        <a href="<?php echo e($payment->screenshot_url); ?>" target="_blank">
                            <img src="<?php echo e($payment->screenshot_url); ?>" alt="screenshot" class="img-fluid rounded border" style="max-height:480px">
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h4>Update Status</h4></div>
                <div class="card-body">
                    <form method="post" action="<?php echo e(route('admin.payments.updateStatus', $payment)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" <?php echo e($payment->status==='pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="verified" <?php echo e($payment->status==='verified' ? 'selected' : ''); ?>>Verified</option>
                                <option value="rejected" <?php echo e($payment->status==='rejected' ? 'selected' : ''); ?>>Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="Optional notes"><?php echo e(old('admin_notes', $payment->admin_notes)); ?></textarea>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\payments\show.blade.php ENDPATH**/ ?>