

<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Create New Coupon</h2>
        </div>
        <div>
            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-light btn-sm rounded">
                <i class="material-icons md-arrow_back"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.coupons.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Coupon Code *</label>
                        <input type="text" name="code" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('code')); ?>" required>
                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Unique code (e.g., SALE11, NEWUSER20)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" 
                               placeholder="e.g., 11.11 Sale">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"><?php echo e(old('description')); ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Type *</label>
                        <select name="discount_type" class="form-select" required id="discount_type">
                            <option value="percentage" <?php echo e(old('discount_type') == 'percentage' ? 'selected' : ''); ?>>Percentage</option>
                            <option value="fixed" <?php echo e(old('discount_type') == 'fixed' ? 'selected' : ''); ?>>Fixed Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value *</label>
                        <input type="number" name="discount_value" class="form-control" 
                               value="<?php echo e(old('discount_value')); ?>" step="0.01" min="0" max="100" required id="discount_value">
                        <small class="text-muted" id="discount_hint">Enter percentage (e.g., 15 for 15%)</small>
                        <div class="invalid-feedback" id="discount_error" style="display:none;">Percentage discount cannot exceed 100%</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimum Order Amount</label>
                        <input type="number" name="min_order_amount" class="form-control" 
                               value="<?php echo e(old('min_order_amount')); ?>" step="0.01" min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apply On *</label>
                        <select name="apply_on" class="form-select" required id="apply_on">
                            <option value="cart" <?php echo e(old('apply_on') == 'cart' ? 'selected' : ''); ?>>Entire Cart</option>
                            <option value="category" <?php echo e(old('apply_on') == 'category' ? 'selected' : ''); ?>>Category</option>
                            <option value="product" <?php echo e(old('apply_on') == 'product' ? 'selected' : ''); ?>>Product</option>
                            <option value="user" <?php echo e(old('apply_on') == 'user' ? 'selected' : ''); ?>>User Specific</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="category_field" style="display:none;">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="product_field" style="display:none;">
                        <label class="form-label">Product *</label>
                        <select name="product_id" class="form-select">
                            <option value="">Select Product</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" <?php echo e(old('product_id') == $product->id ? 'selected' : ''); ?>>
                                    <?php echo e($product->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3" id="user_field" style="display:none;">
                        <div class="card border p-3 mb-3">
                            <h6 class="mb-3">Customer Assignment Options</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Assign to Logged-in Users (Optional)</label>
                                <select name="assigned_users[]" class="form-select" multiple size="5">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, old('assigned_users', [])) ? 'selected' : ''); ?>>
                                            <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple users</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">OR Assign to Guest Customers by Phone + Email</label>
                                <div id="phone_email_assignments">
                                    <div class="phone-email-row mb-2">
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <input type="text" name="customer_phones[]" class="form-control" 
                                                       placeholder="Phone Number (e.g., 03001234567)" 
                                                       value="<?php echo e(old('customer_phones.0')); ?>">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="email" name="customer_emails[]" class="form-control" 
                                                       placeholder="Email Address" 
                                                       value="<?php echo e(old('customer_emails.0')); ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-phone-email" style="display:none;">
                                                    <i class="material-icons md-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary" id="add_phone_email">
                                    <i class="material-icons md-add"></i> Add Another Customer
                                </button>
                                <small class="d-block text-muted mt-2">
                                    Enter phone number and email. When a customer orders with the same phone + email, they can use this coupon.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valid From</label>
                        <input type="datetime-local" name="valid_from" class="form-control" 
                               value="<?php echo e(old('valid_from')); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valid Until</label>
                        <input type="datetime-local" name="valid_until" class="form-control" 
                               value="<?php echo e(old('valid_until')); ?>" id="valid_until">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">OR Valid For (Days)</label>
                        <input type="number" name="valid_days" class="form-control" 
                               value="<?php echo e(old('valid_days')); ?>" min="1" step="1" id="valid_days">
                        <small class="text-muted">Leave blank if using specific dates. Must be an integer ≥ 1.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" class="form-control" 
                               value="<?php echo e(old('usage_limit')); ?>" min="1">
                        <small class="text-muted">Leave blank for unlimited</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Per Customer Limit</label>
                        <input type="number" name="per_customer_limit" class="form-control" 
                               value="<?php echo e(old('per_customer_limit')); ?>" min="1">
                        <small class="text-muted">How many times a single customer can use this</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" 
                                   <?php echo e(old('status', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="card border">
                            <div class="card-body">
                                <h6 class="card-title">Sale Card Display (Frontend)</h6>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="show_sale_card" 
                                           id="show_sale_card" <?php echo e(old('show_sale_card') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="show_sale_card">
                                        Show as Sale Card on Checkout Page
                                    </label>
                                    <small class="d-block text-muted">If enabled, this coupon will appear as a clickable sale card on the checkout page</small>
                                </div>
                                <div id="sale_card_options" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Card Color (Hex)</label>
                                            <input type="color" name="card_color" class="form-control form-control-color" 
                                                   value="<?php echo e(old('card_color', '#667eea')); ?>">
                                            <small class="text-muted">Or use gradient below</small>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Gradient From (Hex)</label>
                                            <input type="color" name="card_gradient_from" class="form-control form-control-color" 
                                                   value="<?php echo e(old('card_gradient_from', '#667eea')); ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Gradient To (Hex)</label>
                                            <input type="color" name="card_gradient_to" class="form-control form-control-color" 
                                                   value="<?php echo e(old('card_gradient_to', '#764ba2')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Coupon</button>
                    <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Show/hide fields based on apply_on
    $('#apply_on').on('change', function() {
        const value = $(this).val();
        $('#category_field').toggle(value === 'category');
        $('#product_field').toggle(value === 'product');
        $('#user_field').toggle(value === 'user');
    }).trigger('change');

    // Update discount hint and validation
    $('#discount_type').on('change', function() {
        const isPercentage = $(this).val() === 'percentage';
        const hint = isPercentage 
            ? 'Enter percentage (e.g., 15 for 15%)' 
            : 'Enter fixed amount (e.g., 500 for Rs. 500)';
        $('#discount_hint').text(hint);
        
        // Update max value for percentage
        if (isPercentage) {
            $('#discount_value').attr('max', '100');
        } else {
            $('#discount_value').removeAttr('max');
        }
    }).trigger('change');
    
    // Validate percentage on input
    $('#discount_value').on('input', function() {
        const discountType = $('#discount_type').val();
        const value = parseFloat($(this).val());
        
        if (discountType === 'percentage' && value > 100) {
            $(this).addClass('is-invalid');
            $('#discount_error').show();
        } else {
            $(this).removeClass('is-invalid');
            $('#discount_error').hide();
        }
    });

    // Handle valid_days
    $('#valid_days').on('input', function() {
        if ($(this).val()) {
            $('#valid_until').prop('disabled', true);
        } else {
            $('#valid_until').prop('disabled', false);
        }
    });

    $('#valid_until').on('input', function() {
        if ($(this).val()) {
            $('#valid_days').val('');
        }
    });
    
    // Show/hide sale card options
    $('#show_sale_card').on('change', function() {
        $('#sale_card_options').toggle($(this).is(':checked'));
    }).trigger('change');
    
    // Add/remove phone-email rows
    $('#add_phone_email').on('click', function() {
        var newRow = $('.phone-email-row').first().clone();
        newRow.find('input').val('');
        newRow.find('.remove-phone-email').show();
        $('#phone_email_assignments').append(newRow);
    });
    
    $(document).on('click', '.remove-phone-email', function() {
        if ($('.phone-email-row').length > 1) {
            $(this).closest('.phone-email-row').remove();
        } else {
            $(this).closest('.phone-email-row').find('input').val('');
            $(this).hide();
        }
    });
    
    // Show remove button if there's more than one row
    if ($('.phone-email-row').length > 1) {
        $('.remove-phone-email').show();
    }
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\coupons\create.blade.php ENDPATH**/ ?>