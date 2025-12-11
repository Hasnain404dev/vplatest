<?php $__env->startSection('content'); ?>
    <div class="content-header">
            <h2 class="content-title card-title">Category List</h2>
            <div class="">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="material-icons md-add"></i> Add Category
                </button>
            </div>
    </div>

    <div class="col-12">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- Create Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category (Optional)</label>
                            <select class="form-select" id="parent_id" name="parent_id">
                                <option value="">-- No Parent --</option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($parent->id); ?>"><?php echo e($parent->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Display Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Parent Category</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($category->name); ?></strong>
                                    <?php if($category->children->count() > 0): ?>
                                        <span class="badge bg-info ms-2"><?php echo e($category->children->count()); ?> subcategories</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($category->parent ? $category->parent->name : '--'); ?></td>
                                <td><?php echo e($category->slug); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" 
                                           class="btn btn-sm font-sm btn-primary rounded">
                                            <i class="material-icons md-edit"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this category? All subcategories will also be deleted!')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm font-sm btn-danger rounded">
                                                <i class="material-icons md-delete_forever"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Display subcategories if they exist -->
                            <?php if($category->children->count() > 0): ?>
                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="bg-light">
                                        <td></td>
                                        <td>↳ <?php echo e($child->name); ?></td>
                                        <td><?php echo e($child->parent->name); ?></td>
                                        <td><?php echo e($child->slug); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?php echo e(route('admin.categories.edit', $child->id)); ?>" 
                                                   class="btn btn-sm font-sm btn-primary rounded">
                                                    <i class="material-icons md-edit"></i> Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.categories.destroy', $child->id)); ?>" method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm font-sm btn-danger rounded">
                                                        <i class="material-icons md-delete_forever"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No categories found. Create your first category!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($categories->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($categories->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // If there are validation errors, show the modal automatically
    <?php if($errors->any()): ?>
        $(document).ready(function() {
            $('#createCategoryModal').modal('show');
        });
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\categories\index.blade.php ENDPATH**/ ?>