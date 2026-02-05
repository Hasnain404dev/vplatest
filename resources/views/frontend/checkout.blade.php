@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-sm-15">
                        <div class="toggle_info">
                            <span><i class="fi-rs-user mr-10"></i><span class="text-muted">Already have an account?</span>
                                <a href="#loginform" data-bs-toggle="collapse" class="collapsed" aria-expanded="false">Click
                                    here to login</a></span>
                        </div>
                        <div class="panel-collapse collapse login_form" id="loginform">
                            <div class="panel-body">
                                <p class="mb-30 font-sm">If you have shopped with us before, please enter your details
                                    below. If you are a new customer, please proceed to the Billing &amp; Shipping section.
                                </p>
                                <form method="post">
                                    <div class="form-group">
                                        <input type="text" name="email" placeholder="Username Or Email">
                                    </div>
                                    {{-- <div class="form-group">
                                        <input type="password" name="password" placeholder="Password">
                                    </div> --}}
                                    <div class="login_footer form-group">
                                        <div class="chek-form">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="checkbox"
                                                    id="remember" value="">
                                                <label class="form-check-label" for="remember"><span>Remember
                                                        me</span></label>
                                            </div>
                                        </div>
                                        <a href="#">Forgot password?</a>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-md" name="login">Log in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if(isset($saleCoupons) && $saleCoupons->count() > 0)
                            <div class="mb-3">
                                <h5 class="mb-3">Special Offers</h5>
                                <div class="row g-2">
                                    @foreach($saleCoupons as $saleCoupon)
                                        <div class="col-12">
                                            <div class="sale-card border rounded p-3 cursor-pointer" 
                                                 style="
                                                    @if($saleCoupon->card_gradient_from && $saleCoupon->card_gradient_to)
                                                        background: linear-gradient(135deg, {{ $saleCoupon->card_gradient_from }} 0%, {{ $saleCoupon->card_gradient_to }} 100%);
                                                    @elseif($saleCoupon->card_color)
                                                        background: {{ $saleCoupon->card_color }};
                                                    @else
                                                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                    @endif
                                                    color: white; transition: transform 0.2s;"
                                                 data-coupon-code="{{ $saleCoupon->code }}"
                                                 onclick="applySaleCoupon('{{ $saleCoupon->code }}')">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 fw-bold">{{ $saleCoupon->title }}</h6>
                                                        <p class="mb-0 small">{{ $saleCoupon->description ?? 'Click to apply this offer' }}</p>
                                                    </div>
                                                    <div class="text-end">
                                                        @if($saleCoupon->discount_type === 'percentage')
                                                            <span class="badge bg-light text-dark fs-6">{{ $saleCoupon->discount_value }}% OFF</span>
                                                        @else
                                                            <span class="badge bg-light text-dark fs-6">Rs. {{ $saleCoupon->discount_value }} OFF</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="coupon_form border rounded p-4" id="coupon">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fi-rs-label mr-10"></i>
                                <div>
                                    <span class="text-muted d-block">Have a coupon?</span>
                                    <strong>Enter your code below</strong>
                                </div>
                            </div>
                            <p class="mb-3 font-sm">If you have a coupon code, please apply it below.</p>
                            <form id="coupon-form" method="post" onsubmit="return false;">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" id="coupon_code" name="coupon_code_temp"
                                        placeholder="Enter Coupon Code..." class="form-control" required autocomplete="off">
                                    <div id="coupon_message" class="mt-2"></div>
                                </div>
                                <div class="form-group d-flex gap-2">
                                    <button type="button" class="btn btn-md btn-brand flex-grow-1" id="apply_coupon_btn">
                                        Apply Coupon
                                    </button>
                                    <button type="button" class="btn btn-md btn-danger" id="remove_coupon_btn" style="display:none;">
                                        Remove
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="divider mt-50 mb-50"></div>
                    </div>
                </div>
                <form method="post" action="{{ route('frontend.placeOrder') }}" enctype="multipart/form-data" id="checkout-form">
                    @csrf
                    <input type="hidden" name="coupon_code" id="coupon_code_input" value="">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-25">
                                <h4>Billing Details</h4>
                            </div>

                            <div class="form-group">
                                <input type="text" required="" name="fname" placeholder="First name *">
                            </div>
                            <div class="form-group">
                                <input type="text" required="" name="lname" placeholder="Last name *">
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing_address" placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing_address2"  placeholder="Address line2">
                            </div>
                            <div class="form-group">
                                <input  type="text" name="city" placeholder="City / Town">
                            </div>
                            <div class="form-group">
                                <input  type="text" name="state" placeholder="State / County">
                            </div>
                            <div class="form-group">
                                <input  type="text" name="zipcode" placeholder="Postcode / ZIP">
                            </div>
                            <div class="form-group">
                                <input required type="text" name="phone" placeholder="Phone *" pattern="[0-9]{11}" minlength="11" maxlength="11" title="Phone number must be exactly 11 digits">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email address">
                            </div>
                            {{-- <div class="ship_detail">
                                <div class="form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox"
                                                id="differentaddress" value="on">
                                            <label class="form-check-label label_info" data-bs-toggle="collapse"
                                                data-target="#collapseAddress" href="#collapseAddress"
                                                aria-controls="collapseAddress" for="differentaddress"><span>Ship to a
                                                    different address?</span></label>
                                        </div>
                                    </div>
                                    <div id="collapseAddress" class="different_address collapse in">
                                        <div class="form-group">
                                            <input type="text" name="shipping_address"  placeholder="Address *">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="shipping_address2" 
                                                placeholder="Address line2">
                                        </div>
                                        <div class="form-group">
                                            <input  type="text" name="shipping_city" placeholder="City / Town *">
                                        </div>
                                        <div class="form-group">
                                            <input  type="text" name="shipping_state" placeholder="State / County *">
                                        </div>
                                        <div class="form-group">
                                            <input  type="text" name="shipping_zipcode" placeholder="Postcode / ZIP *">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="mb-20">
                                <h5>Additional information</h5>
                            </div>
                            <div class="form-group mb-30">
                                <textarea rows="5" name="order_notes" placeholder="Order notes"></textarea>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="order_review">
                                <div class="mb-20">
                                    <h4>Your Orders</h4>
                                </div>
                                <div class="table-responsive order_table text-center">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cartItems as $item)
                                                <tr>
                                                    <td class="image product-thumbnail">
                                                        <img src="{{ asset('uploads/products/' . $item->product->main_image) }}"
                                                            alt="{{ $item->product->name }}">
                                                    </td>
                                                    <td>
                                                        <h5><a
                                                                href="{{ route('frontend.productDetail', $item->product) }}">{{ $item->product->name }}</a>
                                                        </h5>
                                                        <span class="product-qty">x {{ $item->quantity }}</span><br>
                                                        <span class="product-qty">color {{ $item->color_name }}</span>

                                                    </td>
                                                    <td>Rs. {{ $item->total_price }}</td>
                                                </tr>
                                            @empty
                                                @if (!isset($prescription))
                                                    <tr>
                                                        <td colspan="3">Your cart is empty</td>
                                                    </tr>
                                                @endif
                                            @endforelse

                                            @if (isset($prescription) && $prescription)
                                                <tr>
                                                    <td class="image product-thumbnail">
                                                        <img src="{{ asset('uploads/products/' . $prescription->product->main_image) }}"
                                                            alt="{{ $prescription->product->name }}">
                                                    </td>
                                                    <td>
                                                        <h5><a
                                                                href="{{ route('frontend.productDetail', $prescription->product) }}">
                                                                {{ $prescription->product->name }} (with Prescription)
                                                            </a></h5>
                                                        <div class="small text-muted">
                                                            @if($prescription->lens_type)
                                                                <div>Lens Type: {{ $prescription->lens_type }}</div>
                                                            @endif

                                                            @if ($prescription->lens_feature)
                                                                <div>Feature: {{ $prescription->lens_feature }}</div>
                                                            @endif

                                                            @if ($prescription->lens_option)
                                                                <div>Option: {{ $prescription->lens_option }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="small text-muted">
                                                            @php
                                                                $prescriptionData = json_decode($prescription->prescription_data, true);
                                                            @endphp

                                                            @if($prescription->lens_type != 'Non-Prescription')
                                                                @if (isset($prescriptionData['od']) || isset($prescriptionData['os']))
                                                                    <!-- Right Eye (OD) -->
                                                                    @if(isset($prescriptionData['od']['sph']) || isset($prescriptionData['od']['cyl']) || isset($prescriptionData['od']['axis']))
                                                                        <div class="mt-2"><strong>Right Eye (OD):</strong></div>

                                                                        @if(isset($prescriptionData['od']['sph']))
                                                                            <div>SPH: {{ $prescriptionData['od']['sph'] }}</div>
                                                                        @endif

                                                                        @if(isset($prescriptionData['od']['cyl']))
                                                                            <div>CYL: {{ $prescriptionData['od']['cyl'] }}</div>
                                                                        @endif

                                                                        @if(isset($prescriptionData['od']['axis']))
                                                                            <div>AXIS: {{ $prescriptionData['od']['axis'] }}</div>
                                                                        @endif

                                                                        @if (isset($prescriptionData['od']['add']))
                                                                            <div>ADD: {{ $prescriptionData['od']['add'] }}</div>
                                                                        @endif
                                                                    @endif

                                                                    <!-- Left Eye (OS) -->
                                                                    @if(isset($prescriptionData['os']['sph']) || isset($prescriptionData['os']['cyl']) || isset($prescriptionData['os']['axis']))
                                                                        <div class="mt-2"><strong>Left Eye (OS):</strong></div>

                                                                        @if(isset($prescriptionData['os']['sph']))
                                                                            <div>SPH: {{ $prescriptionData['os']['sph'] }}</div>
                                                                        @endif

                                                                        @if(isset($prescriptionData['os']['cyl']))
                                                                            <div>CYL: {{ $prescriptionData['os']['cyl'] }}</div>
                                                                        @endif

                                                                        @if(isset($prescriptionData['os']['axis']))
                                                                            <div>AXIS: {{ $prescriptionData['os']['axis'] }}</div>
                                                                        @endif

                                                                        @if (isset($prescriptionData['os']['add']))
                                                                            <div>ADD: {{ $prescriptionData['os']['add'] }}</div>
                                                                        @endif
                                                                    @endif

                                                                    @if (isset($prescriptionData['pd']) && $prescriptionData['pd'])
                                                                        <div class="mt-2"><strong>PD:</strong> {{ $prescriptionData['pd'] }}
                                                                        </div>
                                                                    @endif

                                                                    @if (isset($prescriptionData['pdDual']) && ($prescriptionData['pdDual']['right'] || $prescriptionData['pdDual']['left']))
                                                                        <div class="mt-2"><strong>Dual PD:</strong></div>

                                                                        @if($prescriptionData['pdDual']['right'])
                                                                            <div>Right: {{ $prescriptionData['pdDual']['right'] }}</div>
                                                                        @endif

                                                                        @if($prescriptionData['pdDual']['left'])
                                                                            <div>Left: {{ $prescriptionData['pdDual']['left'] }}</div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif

                                                            <!-- Show uploaded prescription image if available -->
                                                            @if ($prescription->prescription_type == 'upload' && $prescription->prescription_image)
                                                                <div class="mt-3">
                                                                    <strong>Prescription Image:</strong>
                                                                    <div class="mt-2">
                                                                        <img src="{{ asset($prescription->prescription_image) }}"
                                                                            alt="Prescription Image"
                                                                            class="img-fluid rounded border"
                                                                            style="max-height: 200px;">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>Rs. {{ $prescription->total_price }}</td>
                                                </tr>
                                            @endif

                                            @if (isset($lensesPrescription) && $lensesPrescription)
                                                <tr>
                                                    <td class="image product-thumbnail">
                                                        <img src="{{ asset('uploads/products/' . $lensesPrescription->product->main_image) }}"
                                                            alt="{{ $lensesPrescription->product->name }}">
                                                    </td>
                                                    <td>
                                                        <h5>
                                                            <a
                                                                href="{{ route('frontend.productDetail', $lensesPrescription->product) }}">
                                                                {{ $lensesPrescription->product->name }} (Lenses
                                                                Prescription)
                                                            </a>
                                                        </h5>
                                                        <div class="small text-muted">

                                                            @isset($lensesPrescription->sph_right)
                                                                <div>SPH Right: {{ $lensesPrescription->sph_right }}</div>
                                                            @endisset

                                                            @isset($lensesPrescription->sph_left)
                                                                <div>SPH Left: {{ $lensesPrescription->sph_left }}</div>
                                                            @endisset

                                                            @isset($lensesPrescription->sph)
                                                                <div>SPH: {{ $lensesPrescription->sph }}</div>
                                                            @endisset

                                                            @isset($lensesPrescription->cyl)
                                                                <div>CYL: {{ $lensesPrescription->cyl }}</div>
                                                            @endisset

                                                            @isset($lensesPrescription->axis)
                                                                <div>AXIS: {{ $lensesPrescription->axis }}</div>
                                                            @endisset

                                                            @isset($lensesPrescription->quantity)
                                                                <div>Quantity: {{ $lensesPrescription->quantity }}</div>
                                                            @endisset
                                                        </div>
                                                    </td>
                                                    <td>Rs. {{ $lensesPrescription->total_price }}</td>
                                                </tr>
                                            @endif
                                            @php
                                                $cartTotal = $cartItems->sum('total_price');
                                                $prescriptionTotal = isset($prescription)
                                                    ? $prescription->total_price
                                                    : 0;
                                                $lensesPrescriptionTotal = isset($lensesPrescription)
                                                    ? $lensesPrescription->total_price
                                                    : 0;
                                                $grandTotal =
                                                    $cartTotal + $prescriptionTotal + $lensesPrescriptionTotal;
                                                // Always round up the final payable amount (e.g., 245.05 → 246)
                                                $grandTotal = ceil($grandTotal);
                                            @endphp

                                            <tr>
                                                <th>SubTotal</th>
                                                <td class="product-subtotal" colspan="2">Rs. <span id="subtotal">{{ $cartTotal }}</span></td>
                                            </tr>
                                            <tr id="coupon_discount_row" style="display:none;">
                                                <th>Coupon Discount (<span id="coupon_code_display"></span>)</th>
                                                <td colspan="2" class="text-success">
                                                    -Rs. <span id="coupon_discount_amount">0</span>
                                                </td>
                                            </tr>

                                            @if (isset($lensesPrescription) && $lensesPrescription)
                                                <tr>
                                                    <th>Lenses Prescription</th>
                                                    <td colspan="2">Rs. {{ $lensesPrescription->total_price }}</td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <th>Shipping</th>
                                                <td colspan="2"><em>Free Shipping</em></td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td colspan="2" class="product-subtotal">
                                                    <span class="font-xl text-brand fw-900">Rs. <span id="grand_total">{{ $grandTotal }}</span></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                <div class="payment_method">
                                    <div class="mb-25">
                                        <h5>Payment Method</h5>
                                        <p class="text-muted small">Choose your preferred payment method</p>
                                    </div>

                                    

                                    <div class="payment_option">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="card payment-option-card" data-payment="cash_on_delivery">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" name="payment_option" id="pay_cod" value="cash_on_delivery" checked data-bs-toggle="collapse" data-bs-target=".payment-details" aria-expanded="false" aria-controls="jazzcashPane meezanPane">
                                                            </div>
                                                            <div class="payment-icon me-3">
                                                                <i class="fi-rs-truck text-primary" style="font-size: 24px;"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <label class="form-check-label w-100" for="pay_cod">
                                                                    <h6 class="mb-1">Cash on Delivery</h6>
                                                                    <small class="text-muted">Pay when your order arrives</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="card payment-option-card" data-payment="jazzcash">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" name="payment_option" id="pay_jazzcash" value="jazzcash" data-bs-toggle="collapse" data-bs-target="#jazzcashPane" aria-expanded="false" aria-controls="jazzcashPane">
                                                            </div>
                                                            <div class="payment-icon me-3">
                                                                <i class="fi-rs-mobile text-success" style="font-size: 24px;"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <label class="form-check-label w-100" for="pay_jazzcash">
                                                                    <h6 class="mb-1">JazzCash</h6>
                                                                    <small class="text-muted">Mobile wallet payment</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="card payment-option-card" data-payment="meezan_bank">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" name="payment_option" id="pay_meezan" value="meezan_bank" data-bs-toggle="collapse" data-bs-target="#meezanPane" aria-expanded="false" aria-controls="meezanPane">
                                                            </div>
                                                            <div class="payment-icon me-3">
                                                                <i class="fi-rs-credit-card text-info" style="font-size: 24px;"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <label class="form-check-label w-100" for="pay_meezan">
                                                                    <h6 class="mb-1">Meezan Bank</h6>
                                                                    <small class="text-muted">Bank transfer payment</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                        </div>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- JazzCash Payment Details -->
                                    <div class="collapse payment-details mt-4" id="jazzcashPane" data-bs-parent=".payment_method">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0"><i class="fi-rs-mobile me-2"></i>JazzCash Payment Details</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-info">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fi-rs-info me-2"></i>
                                                        <div>
                                                            <strong>Account Details:</strong><br>
                                                            <small>Account Title: Abdullah Maqbool Khan<br>
                                                            Number: 03391339339</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold">Upload Payment Screenshot <span class="text-danger">*</span></label>
                                                            <input type="file" class="form-control" name="jazzcash_screenshot" accept="image/*" id="jazzcash_screenshot">
                                                            <div class="form-text">Upload a clear screenshot of your JazzCash payment</div>
                                                            <div id="jazzcash_file_name" class="mt-2 text-success small"></div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-6">-->
                                                    <!--    <div class="form-group mb-3">-->
                                                    <!--        <label class="form-label fw-bold">Transaction ID <span class="text-danger">*</span></label>-->
                                                    <!--        <input type="text" class="form-control" name="jazzcash_transaction_id" placeholder="Enter your JazzCash transaction ID" id="jazzcash_transaction">-->
                                                    <!--        <div class="form-text">Enter the transaction ID from your JazzCash app</div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Meezan Bank Payment Details -->
                                    <div class="collapse payment-details mt-4" id="meezanPane" data-bs-parent=".payment_method">
                                        <div class="card border-info">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="mb-0"><i class="fi-rs-credit-card me-2"></i>Meezan Bank Payment Details</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-info">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fi-rs-info me-2"></i>
                                                        <div>
                                                            <strong>Account Details:</strong><br>
                                                            <small>Account Title: Vision Plus<br>
                                                            Number: 02540112931444</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold">Upload Payment Screenshot <span class="text-danger">*</span></label>
                                                            <input type="file" class="form-control" name="meezan_screenshot" accept="image/*" id="meezan_screenshot">
                                                            <div class="form-text">Upload a clear screenshot of your bank transfer</div>
                                                            <div id="meezan_file_name" class="mt-2 text-success small"></div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-6">-->
                                                    <!--    <div class="form-group mb-3">-->
                                                    <!--        <label class="form-label fw-bold">Transaction ID <span class="text-danger">*</span></label>-->
                                                    <!--        <input type="text" class="form-control" name="meezan_transaction_id" placeholder="Enter your bank transaction ID" id="meezan_transaction">-->
                                                    <!--        <div class="form-text">Enter the transaction ID from your bank receipt</div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fi-rs-shopping-cart me-2"></i>Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <style>
        .payment-option-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid #e9ecef;
        }
        
        .payment-option-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0,123,255,0.1);
        }
        
        .payment-option-card.active {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
        
        .payment-option-card input[type="radio"]:checked + label {
            color: #007bff;
        }
        
        .payment-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f8f9fa;
        }
        
        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
        
        .file-upload-area.dragover {
            border-color: #007bff;
            background-color: #e3f2fd;
        }
        
        .payment-option-card.selected {
            border-color: #28a745;
            background-color: #d4edda;
        }
        
        .payment-method-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 1000;
            font-weight: bold;
        }
    </style>
    
    <style>
        .sale-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <script>
        // Function to apply sale coupon when card is clicked
        function applySaleCoupon(couponCode) {
            // Set the coupon code in the input field
            var couponInput = document.getElementById('coupon_code');
            if (couponInput) {
                couponInput.value = couponCode;
            }
            
            // Trigger the apply button click
            var applyBtn = document.getElementById('apply_coupon_btn');
            if (applyBtn) {
                applyBtn.click();
            } else {
                // Fallback: manually trigger the apply function
                if (window.CheckoutCoupon && window.CheckoutCoupon.apply) {
                    window.CheckoutCoupon.apply();
                }
            }
        }
        
        // Provide original grand total for external coupon script
        // Always round up the final payable amount (e.g., 245.05 → 246)
        window.originalGrandTotal = (function(){
            var el = document.getElementById('grand_total');
            if(!el) return null;
            var num = parseFloat(el.textContent.replace(/[^0-9.]/g,''));
            return isNaN(num) ? null : Math.ceil(num);
        })();
        
        // Debug: Verify elements exist
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Checkout: DOM loaded');
            console.log('Checkout: Apply button exists?', !!document.getElementById('apply_coupon_btn'));
            console.log('Checkout: Coupon input exists?', !!document.getElementById('coupon_code'));
            console.log('Checkout: Coupon form exists?', !!document.getElementById('coupon-form'));
            console.log('Checkout: CSRF token exists?', !!document.querySelector('meta[name="csrf-token"]'));
        });
    </script>
    <script>
        (function () {
            var APPLY_ENDPOINT = '{{ url('/api/validate-coupon') }}';
            var REMOVE_ENDPOINT = '{{ url('/api/remove-coupon') }}';
            var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '{{ csrf_token() }}';
            var state = { applying: false, originalTotal: null };

            function $(id) { return document.getElementById(id); }
            function getElements() {
                return {
                    input: $('coupon_code'),
                    message: $('coupon_message'),
                    applyBtn: $('apply_coupon_btn'),
                    removeBtn: $('remove_coupon_btn'),
                    subtotal: $('subtotal'),
                    grandTotal: $('grand_total'),
                    discountRow: $('coupon_discount_row'),
                    discountAmount: $('coupon_discount_amount'),
                    codeDisplay: $('coupon_code_display'),
                    hiddenField: $('coupon_code_input')
                };
            }

            function initState(els) {
                if (els.grandTotal && state.originalTotal === null) {
                    var val = parseFloat(els.grandTotal.textContent.replace(/[^0-9.]/g, ''));
                    // Always round up the final payable amount (e.g., 245.05 → 246)
                    state.originalTotal = isNaN(val) ? 0 : Math.ceil(val);
                }
            }

            function setMessage(els, type, text) {
                if (!els.message) return;
                var classes = { success: 'text-success', error: 'text-danger', info: 'text-info', warning: 'text-warning' };
                els.message.className = classes[type] || '';
                els.message.textContent = text || '';
            }

            function toggleButtons(els, applied) {
                if (els.applyBtn) {
                    els.applyBtn.disabled = state.applying;
                    els.applyBtn.style.display = applied ? 'none' : 'inline-block';
                }
                if (els.removeBtn) {
                    els.removeBtn.style.display = applied ? 'inline-block' : 'none';
                    els.removeBtn.disabled = state.applying && applied;
                }
                if (els.input) {
                    els.input.readOnly = applied;
                }
            }

            function updateTotals(els, discount, newTotal) {
                if (els.discountAmount) {
                    els.discountAmount.textContent = Number(discount || 0).toFixed(2);
                }
                if (els.discountRow) {
                    els.discountRow.style.display = discount > 0 ? '' : 'none';
                }
                if (els.grandTotal && newTotal !== undefined) {
                    // Always round up the final payable amount (e.g., 245.05 → 246)
                    var roundedTotal = Math.ceil(Number(newTotal));
                    els.grandTotal.textContent = roundedTotal;
                }
            }

            function resetUI(els) {
                updateTotals(els, 0, state.originalTotal);
                toggleButtons(els, false);
                if (els.codeDisplay) els.codeDisplay.textContent = '';
                if (els.hiddenField) els.hiddenField.value = '';
                if (els.input) {
                    els.input.value = '';
                    els.input.focus();
                }
                setMessage(els, '', '');
            }

            function handleApply(e) {
                if (e && e.preventDefault) {
                    e.preventDefault();
                }
                var els = getElements();
                initState(els);
                var code = (els.input ? els.input.value.trim() : '').toUpperCase();

                if (!code) {
                    setMessage(els, 'error', 'Please enter a coupon code');
                    if (els.input) els.input.focus();
                    return;
                }

                state.applying = true;
                toggleButtons(els, false);
                setMessage(els, 'info', 'Checking coupon...');

                fetch(APPLY_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(function (resp) { return resp.json().then(function (body) { return { ok: resp.ok, body: body }; }); })
                .then(function (res) {
                    if (res.ok && res.body && res.body.success) {
                        updateTotals(els, res.body.discount_amount, res.body.new_total);
                        toggleButtons(els, true);
                        setMessage(els, 'success', res.body.message || 'Coupon applied');
                        if (els.codeDisplay) els.codeDisplay.textContent = code;
                        if (els.hiddenField) els.hiddenField.value = code;
                    } else {
                        setMessage(els, 'error', (res.body && res.body.message) || 'Invalid coupon');
                        if (els.input) {
                            els.input.focus();
                            els.input.select();
                        }
                    }
                })
                .catch(function (err) {
                    console.error('Coupon apply error', err);
                    setMessage(els, 'error', 'Network error. Please try again.');
                })
                .finally(function () {
                    state.applying = false;
                    toggleButtons(els, !!(els.hiddenField && els.hiddenField.value));
                });
            }

            function handleRemove(e) {
                e.preventDefault();
                var els = getElements();
                setMessage(els, 'info', 'Removing coupon...');

                fetch(REMOVE_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ code: els.hiddenField ? els.hiddenField.value : '' })
                })
                .catch(function () { /* ignore errors, just reset UI */ })
                .finally(function () {
                    resetUI(els);
                    setMessage(els, 'success', 'Coupon removed');
                });
            }

            function bind() {
                var els = getElements();
                initState(els);

                if (els.applyBtn && !els.applyBtn.hasAttribute('data-simple-handler')) {
                    els.applyBtn.addEventListener('click', handleApply);
                    els.applyBtn.setAttribute('data-simple-handler', 'true');
                }
                if (els.removeBtn && !els.removeBtn.hasAttribute('data-simple-handler')) {
                    els.removeBtn.addEventListener('click', handleRemove);
                    els.removeBtn.setAttribute('data-simple-handler', 'true');
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bind);
            } else {
                bind();
            }
        })();
    </script>
@endpush