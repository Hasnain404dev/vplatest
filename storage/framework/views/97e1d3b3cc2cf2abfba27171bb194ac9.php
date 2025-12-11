<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 lenspres-image-container">
                <div class="eyeframe-details">
                    <img id="main-product-image" src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                        alt="<?php echo e($product->name); ?>" class="thumbnail" width="50%"  loading="lazy" decoding="async">
                    <div class="eyeframe-name"><?php echo e($product->name); ?></div>
                    <div class="eyeframe-price">
                        <?php if($product->discountprice): ?>
                            <span>Rs. <?php echo e($product->discountprice); ?></span>
                            <span class="old-price text-decoration-line-through text-muted">Rs. <?php echo e($product->price); ?></span>
                        <?php else: ?>
                            <span>Rs. <?php echo e($product->price); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 lenspres-container">
                <div id="lens-product-price">Price: PKR <?php echo e($product->discountprice ?? $product->price); ?></div>
                <div id="lens-prescription-form"></div>
                <button class="pre-cart" onclick="addToCart()">Submit</button>
            </div>
        </div>

    </div>

    <script>
        const currentProductId = <?php echo e($product->id); ?>;
        const baseProductPrice = <?php echo e($product->discountprice ?? $product->price); ?>;
        const lensesPrescriptionId = <?php echo e($product->lenses_prescription_id); ?>;

        // ✅ Call function with correct ID
        document.addEventListener("DOMContentLoaded", () => {
            loadProductPrescription(lensesPrescriptionId);
        });
    </script>


    <script src="<?php echo e(asset('frontend/assets/js/lensesPrescription.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.prescriptionApp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\lensesPrescription.blade.php ENDPATH**/ ?>