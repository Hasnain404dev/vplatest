@extends('frontend.layouts.app')

@section('content')

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
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span>
                    @if ($product->categories->isNotEmpty())
                        {{ $product->categories->first()->name }}
                    @else
                        Products
                    @endif
                    <span></span> {{ $product->name }}
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
                                                    src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                    alt="{{ $product->name }}" class="zoom-target">
                                            </figure>
                                            @if ($product->colors->isNotEmpty())
                                                @foreach ($product->colors as $color)
                                                    @if ($color->image)
                                                        <figure class="border-radius-10 zoom-container">
                                                            <img src="{{ asset('uploads/products/colors/' . $color->image) }}"
                                                                alt="{{ $product->name }} - {{ $color->color_name }}"
                                                                class="zoom-target">
                                                        </figure>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- THUMBNAILS -->
                                        <div class="slider-nav-thumbnails pl-15 pr-15">
                                            <div>
                                                <img src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                    alt="{{ $product->name }}" class="thumbnail"
                                                    data-image="{{ asset('uploads/products/' . $product->main_image) }}">
                                            </div>
                                            @foreach ($product->colors as $color)
                                                @if ($color->image)
                                                    <div>
                                                        <img src="{{ asset('uploads/products/colors/' . $color->image) }}"
                                                            alt="{{ $product->name }} - {{ $color->color_name }}"
                                                            class="thumbnail"
                                                            data-image="{{ asset('uploads/products/colors/' . $color->image) }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Gallery -->
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-info">
                                        <h2 class="title-detail">{{ $product->name }}</h2>
                                        <div class="clearfix product-price-cover">
                                            <div class="product-price primary-color float-left">
                                                <ins><span class="text-brand">Rs
                                                        {{ $product->discountprice ?? $product->price }}</span></ins>
                                                @if ($product->discountprice)
                                                    <ins><span class="old-price font-md ml-15">Rs
                                                            {{ $product->price }}</span></ins>
                                                    <span class="save-price font-md color3 ml-15">{{ $product->discount }}%
                                                        Off</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                        <div class="short-desc mb-30">
                                            <p>{{ $product->description }}</p>
                                        </div>
                                        <div class="product_sort_info font-xs mb-30">
                                            <ul>
                                                <li><i class="fi-rs-credit-card mr-5"></i>Free Home Delivery all over
                                                    Pakistan</li>
                                            </ul>
                                        </div>
                                        @php
                                            $validColors = $product->colors->filter(function ($color) {
                                                return $color->image &&
                                                    !empty($color->color_name) &&
                                                    strtolower($color->color_name) !== 'custom';
                                            });
                                        @endphp

                                        @if ($validColors->isNotEmpty())
                                            <div class="attr-detail attr-color mb-15">
                                                <strong class="mr-10">Color</strong>
                                                <div class="color-radio-group">
                                                    @foreach ($validColors as $color)
                                                        <div class="color-radio-option">
                                                            <input type="radio" id="color-{{ $color->id }}"
                                                                name="color_name" value="{{ $color->color_name }}"
                                                                @if ($loop->first) checked @endif
                                                                data-image="{{ asset('uploads/products/colors/' . $color->image) }}">
                                                            <label for="color-{{ $color->id }}"
                                                                style="background-color: {{ strtolower($color->color_name) }};"
                                                                title="{{ ucfirst($color->color_name) }}">
                                                                <span
                                                                    class="color-name">{{ ucfirst($color->color_name) }}</span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif



                                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                        <div class="detail-extralink" style="display: flex;">
                                            @if (!$product->categories->contains('name', 'Eyeglasses') && !$product->categories->contains('name', 'Contact Lenses'))
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i
                                                            class="fi-rs-angle-small-down"></i></a>
                                                    <span class="qty-val">1</span>
                                                    <a href="#" class="qty-up"><i
                                                            class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                            @endif

                                            <div class="product-extra-link2">
                                                <form action="{{ route('frontend.addToCart') }}" method="POST"
                                                    style="display: inline;" id="add-to-cart-form-{{ $product->id }}">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1"
                                                        class="quantity-input">
                                                    <!-- This will be updated by the JavaScript -->
                                                    <input type="hidden" name="color_name" id="selected-color"
                                                        value="">
                                                    <button type="submit" class="button button-add-to-cart add-to-cart-btn" data-product-id="{{ $product->id }}" id="add-to-cart-btn-{{ $product->id }}">Add to
                                                        cart</button>
                                                </form>

                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();"><i
                                                        class="fi-rs-heart"></i></a>

                                                <form id="add-to-wishlist-{{ $product->id }}"
                                                    action="{{ route('frontend.addToWishList', $product) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                        <div class="selec-btns" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                            @if ($product->categories->contains('name', 'Eyeglasses'))
                                                <a class="select-lens mt-2"
                                                    href="{{ route('prescription.show', $product->id) }}">Select Lens</a>
                                            @endif
                                            @if ($product->categories->contains('name', 'Contact Lenses'))
                                                {{-- @if ($product->categories->where('parent.name', 'Lenses')->isNotEmpty())
                                                --}}
                                                <a class="select-lens mt-2"
                                                    href="{{ route('prescription.lensesPrescription', $product->id) }}">Add
                                                    Lenses
                                                    Prescription</a>
                                            @endif
                                            <a class="select-lens mt-2"
                                                href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20want%20to%20place%20an%20order%20for%20{{ urlencode($product->name) }}.%20Please%20assist%20me.">Order
                                                On WhatsApp</a>

                                            @if ($product->virtual_try_on_image)
                                                <a class="select-lens mt-2"
                                                    href="{{ route('virtual.try.on', $product->slug) }}">2D
                                                    Try
                                                    On</a>
                                            @endif
                                            @if ($product->threeD_try_on_name)
                                                <a class="select-lens mt-2"
                                                    href="{{ route('virtual.try.on.3d', $product->slug) }}">3D Try
                                                    On</a>
                                            @endif
                                        </div>
                                        <ul class="product-meta font-xs color-grey mt-50">
                                            <li class="mb-5">SKU: <a href="#">{{ $product->id }}</a></li>
                                            <li class="mb-5">Categories:
                                                @foreach ($product->categories as $category)
                                                    <a href="#" rel="tag">{{ $category->name }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </li>
                                            <li>Availability:
                                                @if ($product->stock > 0)
                                                    <span class="in-stock text-success ml-5">{{ $product->stock }} Items
                                                        In
                                                        Stock</span>
                                                @else
                                                    <span class="out-of-stock text-danger ml-5">Out of Stock</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 m-auto entry-main-content">
                                    <h2 class="section-title style-1 mb-30">Description</h2>
                                    <div class="description mb-50">
                                        {!! $product->longDescription !!}
                                    </div>

                                    @php
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
                                    @endphp

                                    @if ($hasAdditionalInfo)
                                        <h3 class="section-title style-1 mb-30">Additional info</h3>
                                        <table class="font-md mb-30">
                                            <tbody>
                                                @if ($hasShape)
                                                    <tr>
                                                        <th>Shape</th>
                                                        <td>
                                                            <p>{{ $product->shape }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($hasRim)
                                                    <tr>
                                                        <th>Rim</th>
                                                        <td>
                                                            <p>{{ $product->rim }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($hasMaterial)
                                                    <tr>
                                                        <th>Material</th>
                                                        <td>
                                                            <p>{{ $product->material }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($hasColor)
                                                    <tr>
                                                        <th>Product Color</th>
                                                        <td>
                                                            <p>{{ $product->color }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($hasSize)
                                                    <tr>
                                                        <th>Size</th>
                                                        <td>
                                                            <p>{{ $product->size }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    @endif


                                    <h3 class="section-title style-1 mb-30 mt-30">Reviews
                                        ({{ $product->approvedReviews->count() }})</h3>
                                    <!--Comments-->
                                    <div class="comments-area style-2">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer Reviews
                                                    ({{ $product->approvedReviews->count() }})</h4>
                                                <div class="comment-list">
                                                    @forelse($product->approvedReviews as $review)
                                                        <div class="single-comment justify-content-between d-flex">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <img src="{{ asset('frontend/assets/imgs/page/avatar-6.jpg') }}"
                                                                        alt="{{ $review->name }}">
                                                                    <h6><a href="#">{{ $review->name }}</a></h6>
                                                                    <p class="font-xxs">
                                                                        {{ $review->created_at->format('M Y') }}
                                                                    </p>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="product-rate d-inline-block">
                                                                        <div class="product-rating"
                                                                            style="width:{{ $review->rating * 20 }}%">
                                                                        </div>
                                                                    </div>
                                                                    <p>{{ $review->comment }}</p>

                                                                    @if ($review->images->count() > 0)
                                                                        <div class="review-images mt-2">
                                                                            <div class="row">
                                                                                @foreach ($review->images as $image)
                                                                                    <div
                                                                                        class="col-md-3 col-sm-4 col-6 mb-2">
                                                                                        <a href="{{ asset('uploads/reviews/' . $image->image) }}"
                                                                                            target="_blank">
                                                                                            <img src="{{ asset('uploads/reviews/' . $image->image) }}"
                                                                                                alt="Review Image"
                                                                                                class="img-fluid rounded w-100">
                                                                                        </a>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="d-flex align-items-center">
                                                                            <p class="font-xs mr-30">
                                                                                {{ $review->created_at->format('F d, Y \a\t g:i a') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>No reviews yet. Be the first to review this product!</p>
                                                    @endforelse
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
                                                    action="{{ route('frontend.review.store', $product) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
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
                                                    @if (session('success'))
                                                        <div class="alert alert-success mt-3">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif
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
                                        @foreach ($relatedProducts as $relatedProduct)
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap small hover-up">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href="{{ route('frontend.productDetail', $relatedProduct) }}"
                                                                tabindex="0">
                                                                <img class="default-img"
                                                                    src="{{ asset('uploads/products/' . $relatedProduct->main_image) }}"
                                                                    alt="{{ $relatedProduct->name }}">
                                                            </a>
                                                        </div>
                                                        <div class="product-action-1">
                                                            <a aria-label="Quick view" class="action-btn small hover-up"
                                                                href="{{ route('frontend.quick-view', $relatedProduct) }}"
                                                                data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                                    class="fi-rs-search"></i></a>
                                                            <a aria-label="Add To Wishlist"
                                                                class="action-btn small hover-up"
                                                                href="shop-wishlist.html" tabindex="0"><i
                                                                    class="fi-rs-heart"></i></a>
                                                        </div>
                                                        <div
                                                            class="product-badges product-badges-position product-badges-mrg">
                                                            @if ($relatedProduct->status == 'featured')
                                                                <span class="hot">Featured</span>
                                                            @elseif($relatedProduct->status == 'new')
                                                                <span class="new">New</span>
                                                            @elseif($relatedProduct->status == 'popular')
                                                                <span class="best">Popular</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2><a href="{{ route('frontend.productDetail', $relatedProduct) }}"
                                                                tabindex="0">{{ $relatedProduct->name }}</a></h2>
                                                        <div class="product-price">
                                                            <span>Rs
                                                                {{ $relatedProduct->discountprice ?? $relatedProduct->price }}</span>
                                                            @if ($relatedProduct->discountprice)
                                                                <span class="old-price">Rs
                                                                    {{ $relatedProduct->price }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
@endsection
