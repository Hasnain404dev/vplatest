<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Sliders List</h2>
            
        </div>
        <div>
            
            
            <a href="<?php echo e(route('admin.sliders.create')); ?>" class="btn btn-primary btn-sm rounded">Add New Slider</a>
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
                            <th scope="col">Slider Image</th>
                            <th scope="col">slider Heading</th>
                            <th scope="col">Slider Sub Heading</th>
                            <th scope="col">Slider Paragraph</th>
                            <th scope="col">Slider Button</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><img src="<?php echo e(asset($slider->image)); ?>" alt="<?php echo e($slider->heading); ?>" width="10%">
                                </td>
                                <td><?php echo e($slider->heading); ?></td>
                                <td><?php echo e($slider->order); ?></td>
                                <td><?php echo e($slider->is_active ? 'Active' : 'Inactive'); ?></td>
                                <td><?php echo e($slider->button_name); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.sliders.edit', $slider->id)); ?>"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?php echo e(route('admin.sliders.destroy', $slider->id)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\world\Desktop\vppp\vplatest\resources\views/backend/sliders/index.blade.php ENDPATH**/ ?>