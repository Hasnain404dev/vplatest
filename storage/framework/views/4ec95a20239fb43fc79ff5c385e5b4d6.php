<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Products List</h2>
            
        </div>
        <div>
            
            
            <a href="<?php echo e(route('admin.product.create')); ?>" class="btn btn-primary btn-sm rounded">Create new</a>
        </div>
    </div>
    <div class="col-12">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-md-2 col-6">
                    <form action="<?php echo e(route('admin.products')); ?>" method="GET" id="dateFilterForm">
                        <input type="date" name="date_filter" class="form-control"
                            value="<?php echo e(request('date_filter', date('Y-m-d'))); ?>" onchange="this.form.submit()">
                        <?php if(request('status')): ?>
                            <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                        <?php endif; ?>
                    </form>
                </div>
                 <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <form action="<?php echo e(route('admin.products')); ?>" method="GET" class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search product name"
                            value="<?php echo e(request('search')); ?>">
                        <button class="btn btn-light bg" type="submit">
                            <i class="material-icons md-search"></i>
                        </button>
                        
                        <?php if(request('status')): ?>
                            <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                        <?php endif; ?>
                        <?php if(request('date_filter')): ?>
                            <input type="hidden" name="date_filter" value="<?php echo e(request('date_filter')); ?>">
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-2 col-6">
                    <form action="<?php echo e(route('admin.products')); ?>" method="GET">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="">All Products</option>
                            <option value="Featured" <?php echo e(request('status') == 'Featured' ? 'selected' : ''); ?>>Featured</option>
                            <option value="Popular" <?php echo e(request('status') == 'Popular' ? 'selected' : ''); ?>>Popular</option>
                            <option value="New" <?php echo e(request('status') == 'New' ? 'selected' : ''); ?>>New</option>

                        </select>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col"><input type="checkbox"></th>
                            <th scope="col">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Discount Price</th>
                            <th scope="col">Statud</th>
                            <th scope="col">Tags</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <?php if($product->main_image): ?>
                                        <img src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>" class="img-thumbnail"
                                            width="60" alt="Product Image">
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($product->name); ?></td>
                                <td><?php echo e($product->price); ?> PKR</td>
                                <td><?php echo e($product->discountprice); ?> PKR</td>
                                <td>
                                    <span class="badge bg-success"><?php echo e($product->status); ?></span>
                                </td>
                                <td><?php echo e($product->tags); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.product.edit', $product->id)); ?>" class="btn btn-sm btn-warning">
                                        <i class="material-icons md-edit"></i>
                                    </a>

                                    <?php if($product->virtual_try_on_image): ?>
                                        <a href="<?php echo e(route('virtual.try.on', $product->slug)); ?>" class="btn btn-sm btn-primary">
                                            <i class="material-icons md-camera_front"></i>
                                        </a>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('admin.product.delete', $product->id)); ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="material-icons md-delete_forever"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
        <?php echo e($products->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\products\index.blade.php ENDPATH**/ ?>