

<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Bulk Discount Management</h2>
            <p>Apply discounts to multiple products or categories at once</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.bulk-discounts.create')); ?>" class="btn btn-primary btn-sm rounded">
                <i class="material-icons md-add"></i> Create Bulk Discount
            </a>
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

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.bulk-discounts.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by title..." 
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('admin.bulk-discounts.index')); ?>" class="btn btn-light">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Discounts Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Discount</th>
                            <th>Scope</th>
                            <th>Valid Period</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($discount->title ?? 'Untitled Discount'); ?></strong>
                                </td>
                                <td>
                                    <?php if($discount->discount_type === 'percentage'): ?>
                                        <span class="badge bg-info"><?php echo e($discount->discount_value); ?>%</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Rs. <?php echo e($discount->discount_value); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($discount->scope === 'all'): ?>
                                        <span class="badge bg-primary">All Products</span>
                                    <?php elseif($discount->scope === 'category'): ?>
                                        <span class="badge bg-secondary">Categories</span>
                                    <?php elseif($discount->scope === 'products'): ?>
                                        <span class="badge bg-secondary">Selected Products</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo e(ucfirst($discount->scope)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($discount->starts_at && $discount->ends_at): ?>
                                        <small>
                                            <?php echo e($discount->starts_at->format('M d, Y')); ?><br>
                                            to <?php echo e($discount->ends_at->format('M d, Y')); ?>

                                        </small>
                                    <?php else: ?>
                                        <span class="text-muted">No expiry</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox" 
                                               data-id="<?php echo e($discount->id); ?>"
                                               <?php echo e($discount->active ? 'checked' : ''); ?>>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.bulk-discounts.edit', $discount->id)); ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="material-icons md-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.bulk-discounts.destroy', $discount->id)); ?>" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure? This will remove discounts from all affected products.')">
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
                                <td colspan="6" class="text-center py-4">No bulk discounts found. Create your first one!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($discounts->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($discounts->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle status
    $(document).on('change', '.toggle-status', function() {
        const discountId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/bulk-discounts/${discountId}/toggle-status`,
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
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\bulk-discounts\index.blade.php ENDPATH**/ ?>