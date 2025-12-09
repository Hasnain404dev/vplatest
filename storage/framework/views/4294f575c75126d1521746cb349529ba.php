<?php $__env->startSection('content'); ?>

    <style>
        .color-button {
            padding: 8px 14px;
            margin: 5px;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-transform: capitalize;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .color-button:hover {
            transform: scale(1.05);
        }

        .color-radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .color-radio-option {
            position: relative;
        }

        .color-radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .color-radio-option label {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            transition: all 0.3s ease;
        }

        .color-radio-option input[type="radio"]:checked+label {
            border-color: #333;
            transform: scale(1.1);
        }

        .color-radio-option .color-name {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .color-radio-option:hover .color-name {
            display: block;
        }
    </style>
    <main class="main">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('frontend.home')); ?>" rel="nofollow">Home</a>
                    <span></span>
                    <?php if($product->categories->isNotEmpty()): ?>
                        <?php echo e($product->categories->first()->name); ?>

                    <?php else: ?>
                        Products
                    <?php endif; ?>
                    <span></span> <?php echo e($product->name); ?>

                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-detail accordion-detail">
                            <div class="row mb-50">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-gallery">
                                        <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                        <!-- MAIN SLIDES -->
                                        <div class="product-image-slider">
                                            <figure class="border-radius-10 zoom-container">
                                                <img id="main-product-image"
                                                    src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                                                    alt="<?php echo e($product->name); ?>" class="zoom-target">
                                            </figure>
                                            <?php if($product->colors->isNotEmpty()): ?>
                                                <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($color->image): ?>
                                                        <figure class="border-radius-10 zoom-container">
                                                            <img src="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>"
                                                                alt="<?php echo e($product->name); ?> - <?php echo e($color->color_name); ?>"
                                                                class="zoom-target">
                                                        </figure>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                        <!-- THUMBNAILS -->
                                        <div class="slider-nav-thumbnails pl-15 pr-15">
                                            <div>
                                                <img src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                                                    alt="<?php echo e($product->name); ?>" class="thumbnail"
                                                    data-image="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>">
                                            </div>
                                            <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($color->image): ?>
                                                    <div>
                                                        <img src="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>"
                                                            alt="<?php echo e($product->name); ?> - <?php echo e($color->color_name); ?>"
                                                            class="thumbnail"
                                                            data-image="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>">
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <!-- End Gallery -->
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-info">
                                        <h2 class="title-detail"><?php echo e($product->name); ?></h2>
                                        <div class="clearfix product-price-cover">
                                            <div class="product-price primary-color float-left">
                                                <ins><span class="text-brand">Rs
                                                        <?php echo e($product->discountprice ?? $product->price); ?></span></ins>
                                                <?php if($product->discountprice): ?>
                                                    <ins><span class="old-price font-md ml-15">Rs
                                                            <?php echo e($product->price); ?></span></ins>
                                                    <span class="save-price font-md color3 ml-15"><?php echo e($product->discount); ?>%
                                                        Off</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                        <div class="short-desc mb-30">
                                            <p><?php echo e($product->description); ?></p>
                                        </div>
                                        <div class="product_sort_info font-xs mb-30">
                                            <ul>
                                                <li><i class="fi-rs-credit-card mr-5"></i>Free Home Delivery all over
                                                    Pakistan</li>
                                            </ul>
                                        </div>
                                        <?php
                                            $validColors = $product->colors->filter(function ($color) {
                                                return $color->image &&
                                                    !empty($color->color_name) &&
                                                    strtolower($color->color_name) !== 'custom';
                                            });
                                        ?>

                                        <?php if($validColors->isNotEmpty()): ?>
                                            <div class="attr-detail attr-color mb-15">
                                                <strong class="mr-10">Color</strong>
                                                <div class="color-radio-group">
                                                    <?php $__currentLoopData = $validColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="color-radio-option">
                                                            <input type="radio" id="color-<?php echo e($color->id); ?>"
                                                                name="color_name" value="<?php echo e($color->color_name); ?>"
                                                                <?php if($loop->first): ?> checked <?php endif; ?>
                                                                data-image="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>">
                                                            <label for="color-<?php echo e($color->id); ?>"
                                                                style="background-color: <?php echo e(strtolower($color->color_name)); ?>;"
                                                                title="<?php echo e(ucfirst($color->color_name)); ?>">
                                                                <span
                                                                    class="color-name"><?php echo e(ucfirst($color->color_name)); ?></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>



                                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                        <div class="detail-extralink" style="display: flex;">
                                            <?php if(!$product->categories->contains('name', 'Eyeglasses') && !$product->categories->contains('name', 'Contact Lenses')): ?>
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i
                                                            class="fi-rs-angle-small-down"></i></a>
                                                    <span class="qty-val">1</span>
                                                    <a href="#" class="qty-up"><i
                                                            class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                            <?php endif; ?>

                                            <div class="product-extra-link2">
                                                <form action="<?php echo e(route('frontend.addToCart')); ?>" method="POST"
                                                    style="display: inline;" id="add-to-cart-form-<?php echo e($product->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                                    <input type="hidden" name="quantity" value="1"
                                                        class="quantity-input">
                                                    <!-- This will be updated by the JavaScript -->
                                                    <input type="hidden" name="color_name" id="selected-color"
                                                        value="">
                                                    <button type="submit" class="button button-add-to-cart add-to-cart-btn" data-product-id="<?php echo e($product->id); ?>" id="add-to-cart-btn-<?php echo e($product->id); ?>">Add to
                                                        cart</button>
                                                </form>

                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-<?php echo e($product->id); ?>').submit();"><i
                                                        class="fi-rs-heart"></i></a>

                                                <form id="add-to-wishlist-<?php echo e($product->id); ?>"
                                                    action="<?php echo e(route('frontend.addToWishList', $product)); ?>" method="POST"
                                                    style="display: none;">
                                                    <?php echo csrf_field(); ?>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="selec-btns" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                            <?php if($product->categories->contains('name', 'Eyeglasses')): ?>
                                                <a class="select-lens mt-2"
                                                    href="<?php echo e(route('prescription.show', $product->id)); ?>">Select Lens</a>
                                            <?php endif; ?>
                                            <?php if($product->categories->contains('name', 'Contact Lenses')): ?>
                                                
                                                <a class="select-lens mt-2"
                                                    href="<?php echo e(route('prescription.lensesPrescription', $product->id)); ?>">Add
                                                    Lenses
                                                    Prescription</a>
                                            <?php endif; ?>
                                            <a class="select-lens mt-2"
                                                href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20want%20to%20place%20an%20order%20for%20<?php echo e(urlencode($product->name)); ?>.%20Please%20assist%20me.">Order
                                                On WhatsApp</a>

                                            <?php if($product->virtual_try_on_image): ?>
                                                <a class="select-lens mt-2"
                                                    href="<?php echo e(route('virtual.try.on', $product->slug)); ?>">2D
                                                    Try
                                                    On</a>
                                            <?php endif; ?>
                                            <?php if($product->threeD_try_on_name): ?>
                                                <a class="select-lens mt-2"
                                                    href="<?php echo e(route('virtual.try.on.3d', $product->slug)); ?>">3D Try
                                                    On</a>
                                            <?php endif; ?>
                                        </div>
                                        <ul class="product-meta font-xs color-grey mt-50">
                                            <li class="mb-5">SKU: <a href="#"><?php echo e($product->id); ?></a></li>
                                            <li class="mb-5">Categories:
                                                <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="#" rel="tag"><?php echo e($category->name); ?></a>
                                                    <?php if(!$loop->last): ?>
                                                        ,
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </li>
                                            <li>Availability:
                                                <?php if($product->stock > 0): ?>
                                                    <span class="in-stock text-success ml-5"><?php echo e($product->stock); ?> Items
                                                        In
                                                        Stock</span>
                                                <?php else: ?>
                                                    <span class="out-of-stock text-danger ml-5">Out of Stock</span>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 m-auto entry-main-content">
                                    <h2 class="section-title style-1 mb-30">Description</h2>
                                    <div class="description mb-50">
                                        <?php echo $product->longDescription; ?>

                                    </div>

                                    <?php
                                        // Strictly check each field (trim whitespace, ignore empty strings)
                                        $hasShape = isset($product->shape) && strlen(trim($product->shape)) > 0;
                                        $hasRim = isset($product->rim) && strlen(trim($product->rim)) > 0;
                                        $hasMaterial =
                                            isset($product->material) && strlen(trim($product->material)) > 0;
                                        $hasColor = isset($product->color) && strlen(trim($product->color)) > 0;
                                        $hasSize = isset($product->size) && strlen(trim($product->size)) > 0;

                                        // Only show if at least one field has content
                                        $hasAdditionalInfo =
                                            $hasShape || $hasRim || $hasMaterial || $hasColor || $hasSize;
                                    ?>

                                    <?php if($hasAdditionalInfo): ?>
                                        <h3 class="section-title style-1 mb-30">Additional info</h3>
                                        <table class="font-md mb-30">
                                            <tbody>
                                                <?php if($hasShape): ?>
                                                    <tr>
                                                        <th>Shape</th>
                                                        <td>
                                                            <p><?php echo e($product->shape); ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($hasRim): ?>
                                                    <tr>
                                                        <th>Rim</th>
                                                        <td>
                                                            <p><?php echo e($product->rim); ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($hasMaterial): ?>
                                                    <tr>
                                                        <th>Material</th>
                                                        <td>
                                                            <p><?php echo e($product->material); ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($hasColor): ?>
                                                    <tr>
                                                        <th>Product Color</th>
                                                        <td>
                                                            <p><?php echo e($product->color); ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($hasSize): ?>
                                                    <tr>
                                                        <th>Size</th>
                                                        <td>
                                                            <p><?php echo e($product->size); ?></p>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>


                                    <h3 class="section-title style-1 mb-30 mt-30">Reviews
                                        (<?php echo e($product->approvedReviews->count()); ?>)</h3>
                                    <!--Comments-->
                                    <div class="comments-area style-2">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer Reviews
                                                    (<?php echo e($product->approvedReviews->count()); ?>)</h4>
                                                <div class="comment-list">
                                                    <?php $__empty_1 = true; $__currentLoopData = $product->approvedReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <div class="single-comment justify-content-between d-flex">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="<?php echo e(asset('frontend/assets/imgs/page/avatar-6.jpg')); ?>"
                                                                        alt="<?php echo e($review->name); ?>">
                                                                    <h6><a href="#"><?php echo e($review->name); ?></a></h6>
                                                                    <p class="font-xxs">
                                                                        <?php echo e($review->created_at->format('M Y')); ?>

                                                                    </p>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating"
                                                                            style="width:<?php echo e($review->rating * 20); ?>%">
                                                                        </div>
                                                                    </div>
                                                                    <p><?php echo e($review->comment); ?></p>

                                                                    <?php if($review->images->count() > 0): ?>
                                                                        <div class="review-images mt-2">
                                                                            <div class="row">
                                                                                <?php $__currentLoopData = $review->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <div
                                                                                        class="col-md-3 col-sm-4 col-6 mb-2">
                                                                                        <a href="<?php echo e(asset('uploads/reviews/' . $image->image)); ?>"
                                                                                            target="_blank">
                                                                                            <img src="<?php echo e(asset('uploads/reviews/' . $image->image)); ?>"
                                                                                                alt="Review Image"
                                                                                                class="img-fluid rounded w-100">
                                                                                        </a>
                                                                                    </div>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="d-flex align-items-center">
                                                                            <p class="font-xs mr-30">
                                                                                <?php echo e($review->created_at->format('F d, Y \a\t g:i a')); ?>

                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <p>No reviews yet. Be the first to review this product!</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--comment form-->
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="product-rate d-inline-block mb-30">
                                            <div class="product-rating" style="width:80%"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form"
                                                    action="<?php echo e(route('frontend.review.store', $product)); ?>"
                                                    method="POST" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                    placeholder="Write Comment" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name" id="name"
                                                                    type="text" placeholder="Name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" id="email"
                                                                    type="email" placeholder="Email" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="rating">Rating</label>
                                                                <select class="form-control" name="rating"
                                                                    id="rating" required>
                                                                    <option value="">Select Rating</option>
                                                                    <option value="5">5 Stars - Excellent</option>
                                                                    <option value="4">4 Stars - Very Good</option>
                                                                    <option value="3">3 Stars - Good</option>
                                                                    <option value="2">2 Stars - Fair</option>
                                                                    <option value="1">1 Star - Poor</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="review_images">Upload Images (Optional)</label>
                                                                <input class="form-control" name="review_images[]"
                                                                    id="review_images" type="file" accept="image/*"
                                                                    multiple>
                                                                <small class="text-muted">You can select multiple
                                                                    images</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="button button-contactForm">Submit
                                                            Review</button>
                                                    </div>
                                                    <?php if(session('success')): ?>
                                                        <div class="alert alert-success mt-3">
                                                            <?php echo e(session('success')); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-60">
                                <div class="col-12">
                                    <h3 class="section-title style-1 mb-30">Related products</h3>
                                </div>
                                <div class="col-12">
                                    <div class="row related-products">
                                        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap small hover-up">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href="<?php echo e(route('frontend.productDetail', $relatedProduct)); ?>"
                                                                tabindex="0">
                                                                <img class="default-img"
                                                                    src="<?php echo e(asset('uploads/products/' . $relatedProduct->main_image)); ?>"
                                                                    alt="<?php echo e($relatedProduct->name); ?>">
                                                            </a>
                                                        </div>
                                                        <div class="product-action-1">
                                                            <a aria-label="Quick view" class="action-btn small hover-up"
                                                                href="<?php echo e(route('frontend.quick-view', $relatedProduct)); ?>"
                                                                data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                                    class="fi-rs-search"></i></a>
                                                            <a aria-label="Add To Wishlist"
                                                                class="action-btn small hover-up"
                                                                href="shop-wishlist.html" tabindex="0"><i
                                                                    class="fi-rs-heart"></i></a>
                                                        </div>
                                                        <div
                                                            class="product-badges product-badges-position product-badges-mrg">
                                                            <?php if($relatedProduct->status == 'featured'): ?>
                                                                <span class="hot">Featured</span>
                                                            <?php elseif($relatedProduct->status == 'new'): ?>
                                                                <span class="new">New</span>
                                                            <?php elseif($relatedProduct->status == 'popular'): ?>
                                                                <span class="best">Popular</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2><a href="<?php echo e(route('frontend.productDetail', $relatedProduct)); ?>"
                                                                tabindex="0"><?php echo e($relatedProduct->name); ?></a></h2>
                                                        <div class="product-price">
                                                            <span>Rs
                                                                <?php echo e($relatedProduct->discountprice ?? $relatedProduct->price); ?></span>
                                                            <?php if($relatedProduct->discountprice): ?>
                                                                <span class="old-price">Rs
                                                                    <?php echo e($relatedProduct->price); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity buttons
            $('.qty-up').on('click', function(e) {
                e.preventDefault();
                let val = parseInt($('.qty-val').text());
                $('.qty-val').text(val + 1);
                $('.quantity-input').val(val + 1);
            });

            $('.qty-down').on('click', function(e) {
                e.preventDefault();
                let val = parseInt($('.qty-val').text());
                if (val > 1) {
                    $('.qty-val').text(val - 1);
                    $('.quantity-input').val(val - 1);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all color radio inputs
            const colorRadios = document.querySelectorAll('input[name="color_name"]');
            const selectedColorInput = document.getElementById('selected-color');

            // Add change event to each radio input
            colorRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Set the selected color value
                    selectedColorInput.value = this.value;

                    // Optional: Change main product image based on selected color
                    const newImage = this.getAttribute('data-image');
                    if (newImage) {
                        document.getElementById('main-product-image').src = newImage;
                    }
                });
            });

            // Set initial selected color
            const initialColor = document.querySelector('input[name="color_name"]:checked').value;
            selectedColorInput.value = initialColor;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/frontend/productDetail.blade.php ENDPATH**/ ?>