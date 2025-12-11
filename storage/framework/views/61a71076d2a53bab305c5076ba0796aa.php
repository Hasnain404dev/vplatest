<?php if($popup): ?>
    <div class="deal" style="background-image: url('<?php echo e(asset($popup->image_path)); ?>');">
        <div class="deal-top">
            <h2 class="text-brand"><?php echo e($popup->title); ?></h2>
            <h5><?php echo e($popup->description); ?></h5>
        </div>
        <div class="deal-content">
            <div class="product-price">
                <span class="new-price fw-bold">Just <?php echo e($popup->formatted_new_price); ?> PKR!</span>
                <?php if($popup->old_price): ?>
                    <span class="old-price fw-bold"><?php echo e($popup->formatted_old_price); ?>/-</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="deal-bottom">
            <p>Hurry Up! Offer End In:</p>
            <div class="deals-countdown" data-countdown="<?php echo e($popup->offer_ends_at->format('Y/m/d H:i:s')); ?>"></div>
            <a href="<?php echo e($popup->offer_link); ?>" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
        </div>
    </div>
<?php else: ?>
    <div class="text-center py-4">
        <p>No active promotions at the moment.</p>
    </div>
<?php endif; ?>
<?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\partials\popup-content.blade.php ENDPATH**/ ?>