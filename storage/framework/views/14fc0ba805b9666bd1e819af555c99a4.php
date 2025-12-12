<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('frontend.home')); ?>" rel="nofollow">Home</a>
                    <span></span> Shop
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p> We found <strong class="text-brand"><?php echo e($products->total()); ?></strong> items for you!</p>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> <?php echo e(request('show', 12)); ?> <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="<?php echo e(request('show') == 50 ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['show' => 50])); ?>">50</a></li>
                                            <li><a class="<?php echo e(request('show') == 100 ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['show' => 100])); ?>">100</a></li>
                                            <li><a class="<?php echo e(request('show') == 150 ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['show' => 150])); ?>">150</a></li>
                                            <li><a class="<?php echo e(request('show') == 200 ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['show' => 200])); ?>">200</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span>
                                                <?php if(request('sort') == 'featured'): ?>
                                                    Featured
                                                <?php elseif(request('sort') == 'price_low'): ?>
                                                    Price: Low to High
                                                <?php elseif(request('sort') == 'price_high'): ?>
                                                    Price: High to Low
                                                <?php elseif(request('sort') == 'date'): ?>
                                                    Release Date
                                                <?php elseif(request('sort') == 'popular'): ?>
                                                    Popular
                                                <?php elseif(request('sort') == 'new'): ?>
                                                    New
                                                <?php else: ?>
                                                    Featured
                                                <?php endif; ?>
                                                <i class="fi-rs-angle-small-down"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="<?php echo e(request('sort') == 'featured' || !request('sort') ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'featured'])); ?>">Featured</a>
                                            </li>
                                            <li><a class="<?php echo e(request('sort') == 'price_low' ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price_low'])); ?>">Price:
                                                    Low to High</a></li>
                                            <li><a class="<?php echo e(request('sort') == 'price_high' ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'price_high'])); ?>">Price:
                                                    High to Low</a></li>
                                            <li><a class="<?php echo e(request('sort') == 'date' ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'date'])); ?>">Release
                                                    Date</a></li>
                                            <li><a class="<?php echo e(request('sort') == 'popular' ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'popular'])); ?>">Popular</a>
                                            </li>
                                            <li><a class="<?php echo e(request('sort') == 'new' ? 'active' : ''); ?>"
                                                    href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'new'])); ?>">New
                                                    Arrivals</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-grid-3">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-3 col-md-4">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="<?php echo e(route('frontend.productDetail', $product)); ?>">
                                                    <img class="default-img"
                                                        src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                                                        alt="<?php echo e($product->name); ?>" loading="lazy"  />

                                                    <?php if($product->colors->isNotEmpty() && $product->colors[0]->image): ?>
                                                        <img class="hover-img"
                                                            src="<?php echo e(asset('uploads/products/colors/' . $product->colors[0]->image)); ?>"
                                                            alt="<?php echo e($product->name); ?>"  loading="lazy"  />
                                                    <?php else: ?>
                                                        <img class="hover-img"
                                                            src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                                                            alt="<?php echo e($product->name); ?>"  loading="lazy" />
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up quick-view-btn"
                                                    href="<?php echo e(route('frontend.quick-view', $product)); ?>"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                                    data-product-id="<?php echo e($product->id); ?>">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-<?php echo e($product->id); ?>').submit();">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                                <form id="add-to-wishlist-<?php echo e($product->id); ?>"
                                                    action="<?php echo e(route('frontend.addToWishList', $product)); ?>" method="POST"
                                                    style="display: none;">
                                                    <?php echo csrf_field(); ?>
                                                </form>
                                            </div>
                                           <?php if($product->virtual_try_on_image): ?>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">
                                                        <a aria-label="" class=""
                                                            href="<?php echo e(route('virtual.try.on', $product->slug)); ?>">Try
                                                            On</a></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($product->discount): ?>
                                                <div class="product-badges product-badges-positionTwo product-badges-mrg">
                                                    <span class="hot"><?php echo e($product->discount); ?>% Off</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">
                                                    <?php echo e($product->categories->pluck('name')->implode(', ')); ?>

                                                </a>
                                            </div>
                                            <h2><a
                                                    href="<?php echo e(route('frontend.productDetail', $product)); ?>"><?php echo e($product->name); ?></a>
                                            </h2>
                                            

                                            <div class="product-price">
                                                <span><?php echo e($product->discountprice ?? $product->price); ?></span>
                                                <?php if($product->discountprice): ?>
                                                    <span class="old-price"><?php echo e($product->price); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="<?php echo e(route('frontend.productDetail', $product)); ?>"><i
                                                        class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!--pagination-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            <?php echo e($products->onEachSide(1)->links('vendor.pagination.custom')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/frontend/shop.blade.php ENDPATH**/ ?>