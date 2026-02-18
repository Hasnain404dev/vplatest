<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VirtualTryOnController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PopupProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\BulkDiscountController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
// Auth::routes();
// use Illuminate\Support\Facades\Artisan;



// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('login', [FrontendController::class, 'loginForm'])->name('login');

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('register', [FrontendController::class, 'loginForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');




// Route::get('/', [FrontendController::class, 'underWorking'])->name('frontend.underWorking');


Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('frontend.aboutUs');
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions'])->name('frontend.termsConditions');
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('frontend.privacyPolicy');
Route::get('/perchase-guide', [FrontendController::class, 'perchaseGuide'])->name('frontend.perchaseGuide');
Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('frontend.contactUs');
Route::post('/contact-us/store', [FrontendController::class, 'contactStore'])->name('frontend.contactUs.store');
Route::get('/quick-view/{product:slug}', [FrontendController::class, 'quickView'])->name('frontend.quick-view');
Route::get('/search', [FrontendController::class, 'search'])->name('frontend.search');
Route::get('/shop', [FrontendController::class, 'shop'])->name('frontend.shop');
Route::get('/product-detail/{product:slug}', [FrontendController::class, 'productDetail'])->name('frontend.productDetail');

// Virtual Try-On
Route::get('/virtual-try-on', [VirtualTryOnController::class, 'index'])->name('virtual.try.on');

Route::get('/blog', [FrontendController::class, 'blog'])->name('frontend.blog');
Route::get('/blog/{blog:slug}', [FrontendController::class, 'blogDetail'])->name('frontend.blogDetail');

Route::get('/wishlist', [CartController::class, 'wishList'])->name('frontend.wishList');
Route::post('/wishlist/add/{product}', [CartController::class, 'addToWishList'])->name('frontend.addToWishList');
Route::delete('/wishlist/{wishlist}', [CartController::class, 'removeFromWishList'])->name('frontend.removeFromWishList');
Route::post('/wishlist/move-to-cart/{wishlistItem}', [CartController::class, 'moveToCart'])->name('frontend.wishlist.moveToCart');
Route::get('/wishlist/count', [CartController::class, 'getWishlistCount'])->name('frontend.getWishlistCount');
Route::get('/cart', [CartController::class, 'cart'])->name('frontend.cart');
Route::get('/prescription', [CartController::class, 'prescription'])->name('frontend.prescription');
Route::get('/cart', [CartController::class, 'viewCart'])->name('frontend.cart');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('frontend.removeFromCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('frontend.updateCart');

Route::get('/checkout', [CartController::class, 'checkout'])->name('frontend.checkout');

// Prescription routes
Route::get('/prescription/{productId}', [PrescriptionController::class, 'show'])->name('prescription.show');
Route::post('/prescriptions/store', [PrescriptionController::class, 'store'])->name('prescription.store');

Route::get('/lenses-prescription/{productId}', [PrescriptionController::class, 'lensesPrescription'])->name('prescription.lensesPrescription');
Route::post('/lenses-prescription', [PrescriptionController::class, 'lensesPrescriptionStore']);


// Product API route
Route::get('/products/{id}', [PrescriptionController::class, 'getProductData']);

Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('frontend.placeOrder');
Route::get('/order-complete', [FrontendController::class, 'orderComplete'])->name('frontend.orderComplete');


// Cart routes
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('frontend.addToCart');
Route::post('/remove-cart-item', [CartController::class, 'removeCartItem'])->name('frontend.removeCartItem');
Route::post('/update-cart-item', [CartController::class, 'updateCartItem'])->name('frontend.updateCartItem');

// Frontend review route
Route::post('/product/{product}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('frontend.review.store');



/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {

    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [FrontendController::class, 'account'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
// Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/customer', [DashboardController::class, 'customerData'])->name('admin.customersData');
    Route::get('/admin/customer/{id}', [DashboardController::class, 'customerDetail'])->name('admin.customers.detail');
    Route::delete('/admin/customer/delete/{id}', [DashboardController::class, 'customerDelete'])->name('admin.customers.delete');
    Route::get('/admin/customer/export', [DashboardController::class, 'customersExport'])->name('admin.customers.export');

    Route::get('/admin/products', [ProductController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/create', [ProductController::class, 'createProduct'])->name('admin.product.create');
    Route::post('admin/products/store', [ProductController::class, 'productStore'])->name('admin.product.store');

    Route::get('/admin/product/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');
    Route::put('/admin/products/update/{id}', [ProductController::class, 'productUpdate'])->name('admin.product.update');

    Route::get('/admin/orders', [OrderController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/detail/{id}', [OrderController::class, 'orderDetail'])->name('admin.orders.orderDetail');
    Route::get('/admin/order/edit/{id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/admin/order/update/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/admin/order/delete/{id}', [OrderController::class, 'delete'])->name('admin.orders.delete');



    Route::get('/admin/contact-list', [DashboardController::class, 'contactList'])->name('admin.contactList');
    Route::delete('/admin/contact-list/delete/{id}', [DashboardController::class, 'contactDelete'])->name('admin.contactList.delete');


    Route::get('/admin/reviews', [DashboardController::class, 'reviews'])->name('admin.reviews');

    Route::delete('/admin/products/{id}', [ProductController::class, 'deleteProduct'])->name('admin.product.delete');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/sliders', [SliderController::class, 'SliderIndex'])->name('admin.sliders');
    Route::get('/admin/sliders/create', [SliderController::class, 'create'])->name('admin.sliders.create');
    Route::post('/admin/sliders/store', [SliderController::class, 'store'])->name('admin.sliders.store');
    Route::get('/admin/sliders/edit/{slider}', [SliderController::class, 'edit'])->name('admin.sliders.edit');
    Route::put('/admin/sliders/update/{slider}', [SliderController::class, 'update'])->name('admin.sliders.update');
    Route::delete('/admin/sliders/{slider}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');


    Route::get('/admin/popups', [PopupProductController::class, 'index'])->name('admin.popups');
    Route::get('/admin/popups/create', [PopupProductController::class, 'create'])->name('admin.popups.create');
    Route::post('/admin/popups/store', [PopupProductController::class, 'store'])->name('admin.popups.store');
    Route::get('/admin/popups/{popupProduct}/edit', [PopupProductController::class, 'edit'])->name('popup-products.edit');
    Route::put('/admin/popups/{popupProduct}', [PopupProductController::class, 'update'])->name('popup-products.update');
    Route::delete('/admin/popups/{popupProduct}', [PopupProductController::class, 'destroy'])->name('popup-products.destroy');



    Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews');
    Route::put('/admin/reviews/{review}/update-status', [ReviewController::class, 'updateStatus'])->name('admin.reviews.update-status');
    Route::delete('/admin/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');


    Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/admin/blogs/create', [BlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/admin/blogs/store', [BlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/admin/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/admin/blogs/{blog}', [BlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/admin/blogs/{blog}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');

    Route::get('/admin/orders/{id}/print', [OrderController::class, 'print'])->name('admin.orders.print');

    // Payments
    Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/admin/payments/{payment}', [PaymentController::class, 'show'])->name('admin.payments.show');
    Route::put('/admin/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('admin.payments.updateStatus');

    // =========================
    // Coupon Routes
    // =========================
    Route::get('/admin/coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('/admin/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('/admin/coupons/store', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('/admin/coupons/edit/{coupon}', [CouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::put('/admin/coupons/update/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('/admin/coupons/delete/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.delete');

    // =========================
    // Bulk Discount Routes
    // =========================
    Route::get('/admin/bulk-discounts', [BulkDiscountController::class, 'index'])->name('admin.bulk-discounts.index');
    Route::get('/admin/bulk-discounts/create', [BulkDiscountController::class, 'create'])->name('admin.bulk-discounts.create');
    Route::post('/admin/bulk-discounts/store', [BulkDiscountController::class, 'store'])->name('admin.bulk-discounts.store');
    Route::get('/admin/bulk-discounts/edit/{bulkDiscount}', [BulkDiscountController::class, 'edit'])->name('admin.bulk-discounts.edit');
    Route::put('/admin/bulk-discounts/update/{bulkDiscount}', [BulkDiscountController::class, 'update'])->name('admin.bulk-discounts.update');
    Route::delete('/admin/bulk-discounts/delete/{bulkDiscount}', [BulkDiscountController::class, 'destroy'])->name('admin.bulk-discounts.delete');
// });
// Popup route - make sure this is outside any middleware groups
Route::get('/get-active-popup', [PopupProductController::class, 'getActivePopup'])->name('get-active-popup');

/*
|--------------------------------------------------------------------------
| Coupon Validation API (Frontend AJAX)
|--------------------------------------------------------------------------
*/
Route::post('/api/validate-coupon', [CouponController::class, 'validateCoupon'])->name('api.validate-coupon');
Route::post('/api/remove-coupon', [CouponController::class, 'removeCoupon'])->name('api.remove-coupon');


// Fallback route for 404 - must be last!
Route::fallback(function () {
    return redirect()->route('frontend.home');
});


// Route::get('/maintenance-clear', function () {

//     Artisan::call('route:clear');
//     Artisan::call('config:clear');
//     Artisan::call('cache:clear');
//     Artisan::call('view:clear');

//     return 'All cleared successfully!';
// });