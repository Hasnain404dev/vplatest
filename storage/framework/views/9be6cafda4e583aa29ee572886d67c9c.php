

<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Create Bulk Discount</h2>
        </div>
        <div>
            <a href="<?php echo e(route('admin.bulk-discounts.index')); ?>" class="btn btn-light btn-sm rounded">
                <i class="material-icons md-arrow_back"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.bulk-discounts.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" 
                               placeholder="e.g., Winter Sale 2024">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Type *</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percentage" <?php echo e(old('discount_type') == 'percentage' ? 'selected' : ''); ?>>Percentage</option>
                            <option value="fixed" <?php echo e(old('discount_type') == 'fixed' ? 'selected' : ''); ?>>Fixed Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value *</label>
                        <input type="number" name="discount_value" class="form-control" 
                               value="<?php echo e(old('discount_value')); ?>" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Scope *</label>
                        <select name="scope" class="form-select" required id="scope">
                            <option value="all" <?php echo e(old('scope') == 'all' ? 'selected' : ''); ?>>All Products</option>
                            <option value="category" <?php echo e(old('scope') == 'category' ? 'selected' : ''); ?>>By Category</option>
                            <option value="products" <?php echo e(old('scope') == 'products' ? 'selected' : ''); ?>>Selected Products</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="category_field" style="display:none;">
                        <label class="form-label">Select Categories *</label>
                        <select name="category_ids[]" class="form-select" multiple size="5">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" 
                                        <?php echo e(in_array($category->id, old('category_ids', [])) ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple categories</small>
                    </div>
                    <div class="col-md-6 mb-3" id="product_field" style="display:none;">
                        <label class="form-label">Select Products *</label>
                        <select name="product_ids[]" class="form-select" multiple size="10">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" 
                                        <?php echo e(in_array($product->id, old('product_ids', [])) ? 'selected' : ''); ?>>
                                    <?php echo e($product->name); ?> - Rs. <?php echo e($product->price); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple products</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Starts At</label>
                        <input type="datetime-local" name="starts_at" class="form-control" 
                               value="<?php echo e(old('starts_at')); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ends At</label>
                        <input type="datetime-local" name="ends_at" class="form-control" 
                               value="<?php echo e(old('ends_at')); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" 
                                   <?php echo e(old('active', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mt-3">
                    <strong>Note:</strong> This discount will be automatically applied to all matching products. 
                    Existing product discounts may be overwritten.
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create & Apply Discount</button>
                    <a href="<?php echo e(route('admin.bulk-discounts.index')); ?>" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $('#scope').on('change', function() {
        const value = $(this).val();
        $('#category_field').toggle(value === 'category');
        $('#product_field').toggle(value === 'products');
    }).trigger('change');
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/backend/bulk-discounts/create.blade.php ENDPATH**/ ?>