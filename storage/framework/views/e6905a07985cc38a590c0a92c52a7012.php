<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Reviews Management</h2>
            <p>Manage customer product reviews</p>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" placeholder="Search..." class="form-control" id="searchInput">
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </header>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($review->id); ?></td>
                                <td><b><?php echo e($review->product->name); ?></b></td>
                                <td><?php echo e($review->name); ?><br><small><?php echo e($review->email); ?></small></td>
                                <td>
                                    <ul class="rating-stars">
                                        <li style="width: <?php echo e($review->rating * 20); ?>%" class="stars-active">
                                            <img src="/backend/assets/imgs/icons/stars-active.svg" alt="stars" />
                                        </li>
                                        <li>
                                            <img src="/backend/assets/imgs/icons/starts-disable.svg" alt="stars" />
                                        </li>
                                    </ul>
                                </td>
                                <td><?php echo e(Str::limit($review->comment, 50)); ?></td>
                                <td>
                                    <?php if($review->images->count() > 0): ?>
                                        <div class="review-images">
                                            <?php $__currentLoopData = $review->images->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(asset('uploads/reviews/' . $image->image)); ?>" target="_blank" class="me-1">
                                                    <img src="<?php echo e(asset('uploads/reviews/' . $image->image)); ?>"
                                                         alt="Review Image"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($review->images->count() > 3): ?>
                                                <span class="badge bg-secondary">+<?php echo e($review->images->count() - 3); ?> more</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">No Images</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($review->status == 'approved' ? 'success' : ($review->status == 'rejected' ? 'danger' : 'warning')); ?>">
                                        <?php echo e(ucfirst($review->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($review->created_at->format('d.m.Y')); ?></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                            <i class="material-icons md-more_horiz"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <form action="<?php echo e(route('admin.reviews.update-status', $review)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item">Approve</button>
                                            </form>
                                            <form action="<?php echo e(route('admin.reviews.update-status', $review)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="dropdown-item">Reject</button>
                                            </form>
                                            <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-area mt-15 mb-50">
                <?php echo e($reviews->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Simple search functionality
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Status filter
        $("#statusFilter").on("change", function() {
            var value = $(this).val().toLowerCase();
            if (value === "") {
                $("table tbody tr").show();
            } else {
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).find("td:nth-child(7)").text().toLowerCase().indexOf(value) > -1)
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\reviews\index.blade.php ENDPATH**/ ?>