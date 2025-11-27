@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
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
                                        @if($cart && count($cart) > 0 && isset($cart[0]['color_name']))
                                            <th scope="col">Color</th>
                                        @endif
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($cart) > 0)
                                        @foreach($cart as $key => $item)
                                            <tr>
                                                <td class="image product-thumbnail">
                                                    <img src="{{ asset('uploads/products/' . $item['image']) }}"
                                                        alt="{{ $item['name'] }}">
                                                </td>
                                                <td class="product-des product-name">
                                                    <h5 class="product-name">{{ $item['name'] }}</h5>
                                                </td>
                                                @if($item['color_name'])
                                                    <td>
                                                        <h5 class="product-name">{{ $item['color_name'] }}</h5>
                                                    </td>
                                                @endif
                                                <td class="price" data-title="Price">
                                                    @if($item['discount_price'])
                                                        <span>Rs. {{ $item['discount_price'] }}</span>
                                                        <span class="old-price text-decoration-line-through text-muted">Rs.
                                                            {{ $item['regular_price'] }}</span>
                                                    @else
                                                        <span>Rs. {{ $item['regular_price'] }}</span>
                                                    @endif
                                                </td>

                                                <td class="text-center" data-title="Quantity">
                                                    <div class="detail-qty border radius m-auto">
                                                        <a href="#" class="qty-down" data-key="{{ $item['cart_id'] }}"><i
                                                                class="fi-rs-angle-small-down"></i></a>
                                                        <span class="qty-val">{{ $item['quantity'] }}</span>
                                                        <a href="#" class="qty-up" data-key="{{ $item['cart_id'] }}"><i
                                                                class="fi-rs-angle-small-up"></i></a>
                                                    </div>
                                                </td>
                                                <td class="text-right" data-title="Subtotal">
                                                    <span>Rs. {{ $item['total'] }}</span>
                                                </td>
                                                <td class="action" data-title="Remove">
                                                    <a href="#" class="text-muted remove-from-cart"
                                                        data-key="{{ $item['cart_id'] }}"><i class="fi-rs-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h4>Your cart is empty</h4>
                                                <p>Explore our products and add items to your cart</p>
                                                <a href="{{ route('frontend.home') }}" class="btn btn-fill-out">Continue
                                                    Shopping</a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-action text-end">
                            <a class="btn" href="{{ route('frontend.home') }}"><i
                                    class="fi-rs-shopping-bag mr-10"></i>Continue Shopping</a>
                        </div>
                        @if(count($cart) > 0)
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
                                                                                {{ array_sum(array_map(function ($item) {
                                return $item['price'] * $item['quantity'];
                            }, $cart)) }}
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
                                                                                    {{ array_sum(array_map(function ($item) {
                                return $item['price'] * $item['quantity'];
                            }, $cart)) }}
                                                                                </span></strong>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <a href="{{ route('frontend.checkout') }}"
                                                            class="btn btn-fill-out btn-block mt-30">Proceed To Checkout</a>
                                                    </div>
                                                </div>
                                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Remove from cart
            $('.remove-from-cart').on('click', function (e) {
                e.preventDefault();
                const cartId = $(this).data('key');

                $.ajax({
                    url: '{{ route("frontend.removeCartItem") }}',
                    type: 'POST',
                    data: {
                        id: cartId,
                        _token: '{{ csrf_token() }}'
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
                    url: '{{ route("frontend.updateCartItem") }}',
                    type: 'POST',
                    data: {
                        id: cartId,
                        action: isUp ? 'increase' : 'decrease',
                        _token: '{{ csrf_token() }}'
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
@endpush