@if (isset($product) && $product)
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-gallery">
                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                <!-- MAIN SLIDES -->
                <div class="product-image-slider">
                    <!-- Main product image -->
                    @if ($product->main_image)
                        <figure class="border-radius-10">
                            <img src="{{ asset('uploads/products/' . $product->main_image) }}" alt="{{ $product->name }}"
                                data-index="0" />
                        </figure>
                    @else
                        <figure class="border-radius-10">
                            <img src="{{ asset('frontend/assets/imgs/shop/product-placeholder.jpg') }}"
                                alt="{{ $product->name }}" data-index="0" />
                        </figure>
                    @endif

                    <!-- Color images -->
                    @if (isset($product->colors) && $product->colors->count() > 0)
                        @foreach ($product->colors as $index => $color)
                            @if ($color->image)
                                <figure class="border-radius-10">
                                    <img src="{{ asset('uploads/products/colors/' . $color->image) }}"
                                        alt="{{ $product->name }} - {{ $color->color_name }}" data-index="{{ $index + 1 }}"
                                        data-color="{{ $color->color_name }}" />
                                </figure>
                            @endif
                        @endforeach
                    @endif
                </div>

                <!-- THUMBNAILS -->
                <div class="slider-nav-thumbnails pl-15 pr-15">
                    <!-- Main image thumbnail -->
                    @if ($product->main_image)
                        <div>
                            <img src="{{ asset('uploads/products/' . $product->main_image) }}" alt="{{ $product->name }}"
                                data-index="0" />
                        </div>
                    @else
                        <div>
                            <img src="{{ asset('frontend/assets/imgs/shop/product-placeholder.jpg') }}"
                                alt="{{ $product->name }}" data-index="0" />
                        </div>
                    @endif

                    <!-- Color image thumbnails -->
                    @if (isset($product->colors) && $product->colors->count() > 0)
                        @foreach ($product->colors as $index => $color)
                            @if ($color->image)
                                <div>
                                    <img src="{{ asset('uploads/products/colors/' . $color->image) }}"
                                        alt="{{ $product->name }} - {{ $color->color_name }}" data-index="{{ $index + 1 }}"
                                        data-color="{{ $color->color_name }}" />
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- End Gallery -->
            <div class="social-icons single-share">
                <ul class="text-grey-5 d-inline-block">
                    <li><strong class="mr-10">Share this:</strong></li>
                    <li class="social-facebook">
                        <a href="https://www.facebook.com/VisionPlusOpticianPK"><img
                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook.svg') }}" alt="" /></a>
                    </li>
                    <li class="social-instagram">
                        <a href="https://www.instagram.com/visionplusopticianspk/"><img
                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram.svg') }}" alt="" /></a>
                    </li>
                    <li class="social-youtube">
                        <a href="https://www.youtube.com/@VisionPlusOptician"><img
                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube.svg') }}" alt="" /></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-info">
                <h3 class="title-detail mt-30">{{ $product->name }}</h3>
                <div class="clearfix product-price-cover">
                    <div class="product-price primary-color float-left">
                        <ins><span class="text-brand">Rs {{ $product->discountprice ?? $product->price }}</span></ins>
                        @if ($product->discountprice)
                            <ins><span class="old-price font-md ml-15">Rs {{ $product->price }}</span></ins>
                            <span class="save-price font-md color3 ml-15">{{ $product->discount }}% Off</span>
                        @endif
                    </div>
                </div>
                <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                <div class="short-desc mb-30">
                    <p class="font-sm">{{ $product->description ?? 'No description available' }}</p>
                </div>
                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                <div class="detail-extralink">
                    <div class="detail-qty border radius">
                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                        <span class="qty-val">1</span>
                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                    </div>
                    <div class="product-extra-link2">
                        <form action="{{ route('frontend.addToCart') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1" class="quantity-input">
                            <!-- This will be updated by the JavaScript -->
                            <input type="hidden" name="color_name" id="selected-color" value="">
                            <button type="submit" class="button button-add-to-cart add-to-cart-btn" data-product-id="{{ $product->id }}">Add to
                                cart</button>
                        </form>
                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="javascript:void(0);"
                            onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();">
                            <i class="fi-rs-heart"></i>
                        </a>
                        <form id="add-to-wishlist-{{ $product->id }}"
                            action="{{ route('frontend.addToWishList', $product) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <div class="selec-btns mt-2" style="display: flex; gap: 10px; flex-wrap: wrap">
                        @if ($product->categories->contains('name', 'Eyeglasses'))
                            <a class="select-lens" href="{{ route('prescription.show', $product->id) }}">Select Lens</a>
                        @endif
                        @if ($product->categories->contains('name', 'Contact Lenses'))
                            <a class="select-lens" href="{{ route('prescription.lensesPrescription', $product->id) }}">Add
                                Lenses Prescription</a>
                        @endif
                        <a class="select-lens"
                            href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20want%20to%20place%20an%20order%20for%20{{ urlencode($product->name) }}.%20Please%20assist%20me.">
                            Order On WhatsApp
                        </a>
                        @if ($product->virtual_try_on_image)
                            <a class="select-lens" href="{{ route('virtual.try.on', $product->slug) }}">2D Try On</a>
                        @endif
                        @if ($product->threeD_try_on_name)
                            <a class="select-lens" href="{{ route('virtual.try.on.3d', $product->slug) }}">3D Try On</a>
                        @endif
                    </div>
                </div>
                <ul class="product-meta font-xs color-grey mt-50">
                    <li class="mb-5">SKU: <a href="#">FWM{{ $product->id }}</a></li>
                    <li>
                        Availability:
                        @if ($product->stock > 0)
                            <span class="in-stock text-success ml-5">{{ $product->stock }} Items In Stock</span>
                        @else
                            <span class="out-of-stock text-danger ml-5">Out of Stock</span>
                        @endif
                    </li>
                </ul>
            </div>
            <!-- Detail Info -->
        </div>
    </div>
@else
    <div class="alert alert-danger">
        Product information not available.
    </div>
@endif

@push('scripts')
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
                    url: '{{ route("frontend.addToCart") }}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
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
@endpush