<?php if($products->count()): ?>
    <div class="search-results-container">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="search-result-item p-3 border-bottom hover-bg-light">
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('frontend.productDetail', $product->slug)); ?>">
                        <div class="product-image-wrapper me-3"
                            style="width: 70px; height: 70px; overflow: hidden; border-radius: 8px;">
                            <?php if($product->main_image): ?>
                                <img src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>" alt="<?php echo e($product->name); ?>"
                                    class="w-100 h-100 object-fit-cover">
                            <?php else: ?>
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info-wrapper flex-grow-1">
                            <h6 class="text-center product-title mb-1 text-dark"><?php echo e($product->name); ?></h6>
                            <div class="product-price mb-2">
                                <?php if($product->discountprice && $product->discountprice < $product->price): ?>
                                    <span class="text-center fw-bold text-danger">Rs
                                        <?php echo e(number_format($product->discountprice, 2)); ?></span>
                                    <span class="text-center text-decoration-line-through text-muted small ms-2">Rs
                                        <?php echo e(number_format($product->price, 2)); ?></span>
                                <?php else: ?>
                                    <span class="text-center fw-bold">Rs <?php echo e(number_format($product->price, 2)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div class="no-results-found p-4 text-center">
        <i class="fas fa-search text-muted mb-2" style="font-size: 2rem;"></i>
        <p class="text-muted mb-0">No products found</p>
    </div>
<?php endif; ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\partials\search-results.blade.php ENDPATH**/ ?>