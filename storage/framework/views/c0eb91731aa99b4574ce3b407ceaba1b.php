<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('frontend.home')); ?>" rel="nofollow">Home</a>
                    <span></span> Cart
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table shopping-summery text-center">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <?php if($cart && count($cart) > 0 && isset($cart[0]['color_name'])): ?>
                                            <th scope="col">Color</th>
                                        <?php endif; ?>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($cart) > 0): ?>
                                        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="image product-thumbnail">
                                                    <img src="<?php echo e(asset('uploads/products/' . $item['image'])); ?>"
                                                        alt="<?php echo e($item['name']); ?>">
                                                </td>
                                                <td class="product-des product-name">
                                                    <h5 class="product-name"><?php echo e($item['name']); ?></h5>
                                                </td>
                                                <?php if($item['color_name']): ?>
                                                    <td>
                                                        <h5 class="product-name"><?php echo e($item['color_name']); ?></h5>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="price" data-title="Price">
                                                    <?php if($item['discount_price']): ?>
                                                        <span>Rs. <?php echo e($item['discount_price']); ?></span>
                                                        <span class="old-price text-decoration-line-through text-muted">Rs.
                                                            <?php echo e($item['regular_price']); ?></span>
                                                    <?php else: ?>
                                                        <span>Rs. <?php echo e($item['regular_price']); ?></span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center" data-title="Quantity">
                                                    <div class="detail-qty border radius m-auto">
                                                        <a href="#" class="qty-down" data-key="<?php echo e($item['cart_id']); ?>"><i
                                                                class="fi-rs-angle-small-down"></i></a>
                                                        <span class="qty-val"><?php echo e($item['quantity']); ?></span>
                                                        <a href="#" class="qty-up" data-key="<?php echo e($item['cart_id']); ?>"><i
                                                                class="fi-rs-angle-small-up"></i></a>
                                                    </div>
                                                </td>
                                                <td class="text-right" data-title="Subtotal">
                                                    <span>Rs. <?php echo e($item['total']); ?></span>
                                                </td>
                                                <td class="action" data-title="Remove">
                                                    <a href="#" class="text-muted remove-from-cart"
                                                        data-key="<?php echo e($item['cart_id']); ?>"><i class="fi-rs-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h4>Your cart is empty</h4>
                                                <p>Explore our products and add items to your cart</p>
                                                <a href="<?php echo e(route('frontend.home')); ?>" class="btn btn-fill-out">Continue
                                                    Shopping</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-action text-end">
                            <a class="btn" href="<?php echo e(route('frontend.home')); ?>"><i
                                    class="fi-rs-shopping-bag mr-10"></i>Continue Shopping</a>
                        </div>
                        <?php if(count($cart) > 0): ?>
                                            <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                                            <div class="row mb-50">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="border p-md-4 p-30 border-radius cart-totals">
                                                        <div class="heading_s1 mb-3">
                                                            <h4>Cart Totals</h4>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="cart_total_label">Cart Subtotal</td>
                                                                        <td class="cart_total_amount">
                                                                            <span class="font-lg fw-900 text-brand">Rs.
                                                                                <?php echo e(array_sum(array_map(function ($item) {
                                return $item['price'] * $item['quantity'];
                            }, $cart))); ?>

                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="cart_total_label">Shipping</td>
                                                                        <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> Free
                                                                            Shipping</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="cart_total_label">Total</td>
                                                                        <td class="cart_total_amount">
                                                                            <strong><span class="font-xl fw-900 text-brand">Rs.
                                                                                    <?php echo e(array_sum(array_map(function ($item) {
                                return $item['price'] * $item['quantity'];
                            }, $cart))); ?>

                                                                                </span></strong>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <a href="<?php echo e(route('frontend.checkout')); ?>"
                                                            class="btn btn-fill-out btn-block mt-30">Proceed To Checkout</a>
                                                    </div>
                                                </div>
                                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            // Remove from cart
            $('.remove-from-cart').on('click', function (e) {
                e.preventDefault();
                const cartId = $(this).data('key');

                $.ajax({
                    url: '<?php echo e(route("frontend.removeCartItem")); ?>',
                    type: 'POST',
                    data: {
                        id: cartId,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Error removing item from cart');
                    }
                });
            });

            // Update quantity
            $('.qty-up, .qty-down').on('click', function (e) {
                e.preventDefault();
                const cartId = $(this).data('key');
                const isUp = $(this).hasClass('qty-up');

                $.ajax({
                    url: '<?php echo e(route("frontend.updateCartItem")); ?>',
                    type: 'POST',
                    data: {
                        id: cartId,
                        action: isUp ? 'increase' : 'decrease',
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Error updating cart');
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/frontend/cart.blade.php ENDPATH**/ ?>