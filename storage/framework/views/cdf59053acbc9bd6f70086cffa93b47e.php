<?php if(isset($product) && $product): ?>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-gallery">
                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                <!-- MAIN SLIDES -->
                <div class="product-image-slider">
                    <!-- Main product image -->
                    <?php if($product->main_image): ?>
                        <figure class="border-radius-10">
                            <img src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>" alt="<?php echo e($product->name); ?>"
                                data-index="0" />
                        </figure>
                    <?php else: ?>
                        <figure class="border-radius-10">
                            <img src="<?php echo e(asset('frontend/assets/imgs/shop/product-placeholder.jpg')); ?>"
                                alt="<?php echo e($product->name); ?>" data-index="0" />
                        </figure>
                    <?php endif; ?>

                    <!-- Color images -->
                    <?php if(isset($product->colors) && $product->colors->count() > 0): ?>
                        <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($color->image): ?>
                                <figure class="border-radius-10">
                                    <img src="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>"
                                        alt="<?php echo e($product->name); ?> - <?php echo e($color->color_name); ?>" data-index="<?php echo e($index + 1); ?>"
                                        data-color="<?php echo e($color->color_name); ?>" />
                                </figure>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

                <!-- THUMBNAILS -->
                <div class="slider-nav-thumbnails pl-15 pr-15">
                    <!-- Main image thumbnail -->
                    <?php if($product->main_image): ?>
                        <div>
                            <img src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>" alt="<?php echo e($product->name); ?>"
                                data-index="0" />
                        </div>
                    <?php else: ?>
                        <div>
                            <img src="<?php echo e(asset('frontend/assets/imgs/shop/product-placeholder.jpg')); ?>"
                                alt="<?php echo e($product->name); ?>" data-index="0" />
                        </div>
                    <?php endif; ?>

                    <!-- Color image thumbnails -->
                    <?php if(isset($product->colors) && $product->colors->count() > 0): ?>
                        <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($color->image): ?>
                                <div>
                                    <img src="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>"
                                        alt="<?php echo e($product->name); ?> - <?php echo e($color->color_name); ?>" data-index="<?php echo e($index + 1); ?>"
                                        data-color="<?php echo e($color->color_name); ?>" />
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Gallery -->
            <div class="social-icons single-share">
                <ul class="text-grey-5 d-inline-block">
                    <li><strong class="mr-10">Share this:</strong></li>
                    <li class="social-facebook">
                        <a href="https://www.facebook.com/VisionPlusOpticianPK"><img
                                src="<?php echo e(asset('frontend/assets/imgs/theme/icons/icon-facebook.svg')); ?>" alt="" /></a>
                    </li>
                    <li class="social-instagram">
                        <a href="https://www.instagram.com/visionplusopticianspk/"><img
                                src="<?php echo e(asset('frontend/assets/imgs/theme/icons/icon-instagram.svg')); ?>" alt="" /></a>
                    </li>
                    <li class="social-youtube">
                        <a href="https://www.youtube.com/@VisionPlusOptician"><img
                                src="<?php echo e(asset('frontend/assets/imgs/theme/icons/icon-youtube.svg')); ?>" alt="" /></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-info">
                <h3 class="title-detail mt-30"><?php echo e($product->name); ?></h3>
                <div class="clearfix product-price-cover">
                    <div class="product-price primary-color float-left">
                        <ins><span class="text-brand">Rs <?php echo e($product->discountprice ?? $product->price); ?></span></ins>
                        <?php if($product->discountprice): ?>
                            <ins><span class="old-price font-md ml-15">Rs <?php echo e($product->price); ?></span></ins>
                            <span class="save-price font-md color3 ml-15"><?php echo e($product->discount); ?>% Off</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                <div class="short-desc mb-30">
                    <p class="font-sm"><?php echo e($product->description ?? 'No description available'); ?></p>
                </div>
                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                <div class="detail-extralink">
                    <div class="detail-qty border radius">
                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                        <span class="qty-val">1</span>
                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                    </div>
                    <div class="product-extra-link2">
                        <form action="<?php echo e(route('frontend.addToCart')); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1" class="quantity-input">
                            <!-- This will be updated by the JavaScript -->
                            <input type="hidden" name="color_name" id="selected-color" value="">
                            <button type="submit" class="button button-add-to-cart add-to-cart-btn" data-product-id="<?php echo e($product->id); ?>">Add to
                                cart</button>
                        </form>
                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="javascript:void(0);"
                            onclick="event.preventDefault(); document.getElementById('add-to-wishlist-<?php echo e($product->id); ?>').submit();">
                            <i class="fi-rs-heart"></i>
                        </a>
                        <form id="add-to-wishlist-<?php echo e($product->id); ?>"
                            action="<?php echo e(route('frontend.addToWishList', $product)); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                    <div class="selec-btns mt-2" style="display: flex; gap: 10px; flex-wrap: wrap">
                        <?php if($product->categories->contains('name', 'Eyeglasses')): ?>
                            <a class="select-lens" href="<?php echo e(route('prescription.show', $product->id)); ?>">Select Lens</a>
                        <?php endif; ?>
                        <?php if($product->categories->contains('name', 'Contact Lenses')): ?>
                            <a class="select-lens" href="<?php echo e(route('prescription.lensesPrescription', $product->id)); ?>">Add
                                Lenses Prescription</a>
                        <?php endif; ?>
                        <a class="select-lens"
                            href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20want%20to%20place%20an%20order%20for%20<?php echo e(urlencode($product->name)); ?>.%20Please%20assist%20me.">
                            Order On WhatsApp
                        </a>
                        <?php if($product->virtual_try_on_image): ?>
                            <a class="select-lens" href="<?php echo e(route('virtual.try.on', $product->slug)); ?>">2D Try On</a>
                        <?php endif; ?>
                        <?php if($product->threeD_try_on_name): ?>
                            <a class="select-lens" href="<?php echo e(route('virtual.try.on.3d', $product->slug)); ?>">3D Try On</a>
                        <?php endif; ?>
                    </div>
                </div>
                <ul class="product-meta font-xs color-grey mt-50">
                    <li class="mb-5">SKU: <a href="#">FWM<?php echo e($product->id); ?></a></li>
                    <li>
                        Availability:
                        <?php if($product->stock > 0): ?>
                            <span class="in-stock text-success ml-5"><?php echo e($product->stock); ?> Items In Stock</span>
                        <?php else: ?>
                            <span class="out-of-stock text-danger ml-5">Out of Stock</span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
            <!-- Detail Info -->
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger">
        Product information not available.
    </div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quantity buttons
            $('.qty-up').on('click', function (e) {
                e.preventDefault();
                let val = parseInt($(this).siblings('.qty-val').text());
                $(this).siblings('.qty-val').text(val + 1);
            });

            $('.qty-down').on('click', function (e) {
                e.preventDefault();
                let val = parseInt($(this).siblings('.qty-val').text());
                if (val > 1) {
                    $(this).siblings('.qty-val').text(val - 1);
                }
            });

            // Add to cart functionality
            $(document).on('click', '.add-to-cart-btn', function (e) {
                e.preventDefault();

                const productId = $(this).data('product-id');
                const quantity = parseInt($(this).closest('.detail-extralink').find('.qty-val').text());
                const button = $(this);

                // Show loading state
                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adding...');

                $.ajax({
                    url: '<?php echo e(route("frontend.addToCart")); ?>',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            // Update cart count in header
                            if (response.cart_count !== undefined) {
                                $('.cart-count').text(response.cart_count);
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = 'Error adding product to cart';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        button.prop('disabled', false).html('Add to cart');
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\partials\quick-view-content.blade.php ENDPATH**/ ?>