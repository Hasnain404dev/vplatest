<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Blog List</h2>
            
        </div>
        <div>
            <a href="#" class="btn btn-light rounded font-md">Export</a>
            
            <a href="<?php echo e(route('admin.blog.create')); ?>" class="btn btn-primary btn-sm rounded">Create new</a>
        </div>
    </div>
    <div class="col-12">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <img src="<?php echo e(asset('uploads/blogs/' . $blog->image)); ?>" alt="<?php echo e($blog->title); ?>"
                                        width="100">
                                </td>
                                <td><?php echo e($blog->title); ?></td>
                                <td><?php echo e($blog->description); ?></td>
                                <td><?php echo e($blog->created_at->format('d M Y')); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.blog.edit', $blog->id)); ?>"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?php echo e(route('admin.blog.destroy', $blog->id)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">No blogs found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\blogs\index.blade.php ENDPATH**/ ?>