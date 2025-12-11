<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="w-50">
                <h2 class="content-title card-title">Popup List</h2>
            </div>
            <div class="w-50 text-end">
                <a href="<?php echo e(route('admin.popups.create')); ?>" class="btn btn-primary">Add New Popup</a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>New Price</th>
                            <th>Old Price</th>
                            <th>Status</th>
                            <th>Expires At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $popupProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td>
                                    <img src="<?php echo e($popup->image_url); ?>" class="img-thumbnail"
                                        style="width: 60px; height: 60px; object-fit: cover;" alt="Popup Image">
                                </td>
                                <td><strong><?php echo e($popup->title); ?></strong></td>
                                <td><?php echo e($popup->formatted_new_price); ?> PKR</td>
                                <td><?php echo e($popup->formatted_old_price ?? 'N/A'); ?> PKR</td>
                                <td>
                                    <span
                                        class="badge rounded-pill <?php echo e($popup->is_active == 1 ? 'alert-success' : 'alert-danger'); ?>">
                                        <?php echo e($popup->is_active == 1 ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>
                                <td><?php echo e($popup->offer_ends_at->format('d M Y H:i')); ?></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light rounded btn-sm font-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="material-icons md-more_horiz"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('popup-products.edit', $popup->id)); ?>">Edit</a>
                                            <form action="<?php echo e(route('popup-products.destroy', $popup->id)); ?>" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
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
                                <td colspan="8" class="text-center">No popup products found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-area mt-15 mb-50">
                <?php echo e($popupProducts->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\popups\index.blade.php ENDPATH**/ ?>