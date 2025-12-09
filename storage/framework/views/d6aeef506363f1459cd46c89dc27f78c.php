

<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Coupon Management</h2>
            <p>Manage all discount coupons and sales campaigns</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary btn-sm rounded">
                <i class="material-icons md-add"></i> Create Coupon
            </a>
            <button class="btn btn-secondary btn-sm rounded" data-bs-toggle="modal" data-bs-target="#bulkGenerateModal">
                <i class="material-icons md-add_circle"></i> Bulk Generate
            </button>
        </div>
    </div>

    <div class="col-12">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-receipt"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Coupons</h6>
                        <span><?php echo e($stats['total']); ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success material-icons md-check_circle"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Active</h6>
                        <span><?php echo e($stats['active']); ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light">
                        <i class="text-warning material-icons md-schedule"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Expired</h6>
                        <span><?php echo e($stats['expired']); ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-danger-light">
                        <i class="text-danger material-icons md-block"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Disabled</h6>
                        <span><?php echo e($stats['disabled']); ?></span>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.coupons.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by code or title..." 
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="expired" <?php echo e(request('status') == 'expired' ? 'selected' : ''); ?>>Expired</option>
                        <option value="disabled" <?php echo e(request('status') == 'disabled' ? 'selected' : ''); ?>>Disabled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-light">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Discount</th>
                            <th>Apply On</th>
                            <th>Valid Period</th>
                            <th>Usage</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong class="text-primary"><?php echo e($coupon->code); ?></strong>
                                </td>
                                <td><?php echo e($coupon->title ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($coupon->discount_type === 'percentage'): ?>
                                        <span class="badge bg-info"><?php echo e($coupon->discount_value); ?>%</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Rs. <?php echo e($coupon->discount_value); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($coupon->apply_on === 'category' && $coupon->category): ?>
                                        <span class="badge bg-secondary"><?php echo e($coupon->category->name); ?></span>
                                    <?php elseif($coupon->apply_on === 'product' && $coupon->product): ?>
                                        <span class="badge bg-secondary"><?php echo e($coupon->product->name); ?></span>
                                    <?php elseif($coupon->apply_on === 'user'): ?>
                                        <span class="badge bg-secondary">User Specific</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Entire Cart</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($coupon->valid_from && $coupon->valid_until): ?>
                                        <small>
                                            <?php echo e($coupon->valid_from->format('M d, Y')); ?><br>
                                            to <?php echo e($coupon->valid_until->format('M d, Y')); ?>

                                        </small>
                                    <?php else: ?>
                                        <span class="text-muted">No expiry</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($coupon->usage_count); ?> / <?php echo e($coupon->usage_limit ?? '∞'); ?>

                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox" 
                                               data-id="<?php echo e($coupon->id); ?>"
                                               <?php echo e($coupon->status ? 'checked' : ''); ?>>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.coupons.analytics', $coupon->id)); ?>" 
                                       class="btn btn-sm btn-info" title="Analytics">
                                        <i class="material-icons md-analytics"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.coupons.edit', $coupon->id)); ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="material-icons md-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.coupons.destroy', $coupon->id)); ?>" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="material-icons md-delete_forever"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">No coupons found. Create your first coupon!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($coupons->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($coupons->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bulk Generate Modal -->
    <div class="modal fade" id="bulkGenerateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Generate Coupons</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin.coupons.bulk-generate')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prefix *</label>
                                <input type="text" name="prefix" class="form-control" required 
                                       placeholder="e.g., SALE11">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" name="quantity" class="form-control" required 
                                       min="1" max="1000" value="10">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type *</label>
                                <select name="discount_type" class="form-select" required>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value *</label>
                                <input type="number" name="discount_value" class="form-control" required 
                                       step="0.01" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apply On *</label>
                                <select name="apply_on" class="form-select" required id="bulk_apply_on">
                                    <option value="cart">Entire Cart</option>
                                    <option value="category">Category</option>
                                    <option value="product">Product</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3" id="bulk_category_field" style="display:none;">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3" id="bulk_product_field" style="display:none;">
                                <label class="form-label">Product</label>
                                <select name="product_id" class="form-select">
                                    <option value="">Select Product</option>
                                    <?php $__currentLoopData = \App\Models\Product::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($prod->id); ?>"><?php echo e($prod->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Valid From</label>
                                <input type="datetime-local" name="valid_from" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Valid Until</label>
                                <input type="datetime-local" name="valid_until" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usage Limit</label>
                                <input type="number" name="usage_limit" class="form-control" min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" checked>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Coupons</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle status
    $(document).on('change', '.toggle-status', function() {
        const couponId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/coupons/${couponId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Error updating status');
            }
        });
    });

    // Show/hide fields based on apply_on
    $('#bulk_apply_on').on('change', function() {
        const value = $(this).val();
        $('#bulk_category_field').toggle(value === 'category');
        $('#bulk_product_field').toggle(value === 'product');
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/backend/coupons/index.blade.php ENDPATH**/ ?>