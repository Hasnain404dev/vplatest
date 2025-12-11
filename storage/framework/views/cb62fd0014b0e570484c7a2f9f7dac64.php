<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('frontend.home')); ?>" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Wishlist
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table shopping-summery text-center">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col" colspan="2">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Stock Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($wishlistItems->count() > 0): ?>
                                        <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="image product-thumbnail">
                                                    <img src="<?php echo e(asset('uploads/products/' . $item->product->main_image)); ?>"
                                                        alt="<?php echo e($item->product->name); ?>">
                                                </td>
                                                <td class="product-des product-name">
                                                    <h5 class="product-name">
                                                        <a
                                                            href="<?php echo e(route('frontend.productDetail', $item->product)); ?>"><?php echo e($item->product->name); ?></a>
                                                    </h5>
                                                    <p class="font-xs">
                                                        <?php echo e($item->product->categories->pluck('name')->implode(', ')); ?>

                                                    </p>
                                                </td>
                                                <td class="price" data-title="Price">
                                                    <span><?php echo e($item->product->discountprice ?? $item->product->price); ?></span>
                                                    <?php if($item->product->discountprice): ?>
                                                        <span class="old-price text-decoration-line-through text-muted"><?php echo e($item->product->price); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center" data-title="Stock">
                                                    <span
                                                        class="color3 font-weight-bold"><?php echo e($item->product->stock > 0 ? 'In Stock' : 'Out of Stock'); ?></span>
                                                </td>
                                                <td class="text-right" data-title="Cart">
                                                    <form action="<?php echo e(route('frontend.wishlist.moveToCart', $item)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm">
                                                            <i class="fi-rs-shopping-bag mr-5"></i>Add to cart
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="action" data-title="Remove">
                                                    <form action="<?php echo e(route('frontend.removeFromWishList', $item)); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn-remove">
                                                            <i class="fi-rs-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h4>Your wishlist is empty</h4>
                                                <p>Explore our products and add items to your wishlist</p>
                                                <a href="<?php echo e(route('frontend.shop')); ?>" class="btn btn-fill-out">Continue
                                                    Shopping</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\wishList.blade.php ENDPATH**/ ?>