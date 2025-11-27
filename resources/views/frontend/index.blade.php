@extends('frontend.layouts.app')

@section('content')


    <main class="main">

     <div id="preloader-active" class="preloader">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <h5 class="mb-10">Sharpening Your Vision...</h5>
                    <div class="loader">
                        <div class="bar bar1"></div>
                        <div class="bar bar2"></div>
                        <div class="bar bar3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        {{-- popup section --}}

        @if ($activePopup)
            <!-- Modal -->
            <div class="modal fade custom-modal" id="onloadModal" tabindex="-1" aria-labelledby="onloadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="deal" style="background-image: url('{{ asset($activePopup->image_path) }}')">
                                <div class="deal-top">
                                    <h2 class="text-brand">{{ $activePopup->title }}</h2>
                                    <h5>{{ $activePopup->description }}</h5>
                                </div>
                                <div class="deal-content">
                                    <div class="product-price">
                                        <span class="new-price fw-bold">Just {{ $activePopup->new_price }} PKR!</span>
                                        @if ($activePopup->old_price)
                                            <span class="old-price fw-bold">{{ $activePopup->old_price }}/-</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="deal-bottom">
                                    <p>Hurry Up! Offer End In:</p>
                                    <div class="deals-countdown"
                                        data-countdown="{{ $activePopup->offer_ends_at->format('Y/m/d H:i:s') }}"></div>
                                    <a href="{{ $activePopup->offer_link }}" class="btn hover-up">Shop Now <i
                                            class="fi-rs-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Show the modal when page loads if it exists
                document.addEventListener('DOMContentLoaded', function() {
                    if (document.getElementById('onloadModal')) {
                        var modal = new bootstrap.Modal(document.getElementById('onloadModal'));
                        modal.show();
                    }
                });
            </script>
        @endif


        {{-- slider section --}}
        <section class="home-slider position-relative pt-50">
            <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
                @foreach ($sliders as $slider)
                    <div class="single-hero-slider single-animation-wrap">
                        <div class="container">
                            <div class="row  align-items-center slider-animated-1">
                                <div class="col-lg-5 col-md-5 col-12">
                                    <div class="hero-slider-content-2">
                                        @if ($slider->heading)
                                            <h4 class="animated">{{ $slider->heading }}</h4>
                                        @endif
                                        @if ($slider->sub_heading)
                                            <h2 class="animated fw-900 text-7">{{ $slider->sub_heading }}</h2>
                                        @endif
                                        <p class="animated overflow-hidden">
                                            {{ $slider->paragraph }}
                                        </p>
                                        @if ($slider->button_name && $slider->button_link)
                                            <a class="animated btn btn-brush btn-brush-3"
                                                href="{{ $slider->button_link }}">
                                                {{ $slider->button_name }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-7 col-12">
                                    <div class="single-slider-img single-slider-img-1">
                                        <img class="animated slider-1-1"
                                        src="{{ asset($slider->image) }}"
                                            alt="{{ $slider->heading }}" 
                                              
                                              fetchpriority="high"
                                            />
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </section>

        {{-- featured section --}}
        <!--<section class="featured section-padding position-relative">-->
        <!--    <div class="container">-->
        <!--        <div class="row justify-content-center">-->
        <!--            <div class="col-lg-2 col-md-3 mb-md-3 mb-lg-0">-->
        <!--                <div class="banner-features wow fadeIn animated hover-up">-->
        <!--                    <img src="frontend/assets/imgs/theme/icons/feature-1.png" alt="" />-->
        <!--                    <h4 class="bg-1">Free Shipping</h4>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-lg-2 col-md-3 mb-md-3 mb-lg-0">-->
        <!--                <div class="banner-features wow fadeIn animated hover-up">-->
        <!--                    <img src="frontend/assets/imgs/theme/icons/feature-2.png" alt="" />-->
        <!--                    <h4 class="bg-3">Online Order</h4>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-lg-2 col-md-3 mb-md-3 mb-lg-0">-->
        <!--                <div class="banner-features wow fadeIn animated hover-up">-->
        <!--                    <img src="frontend/assets/imgs/theme/icons/feature-3.png" alt="" />-->
        <!--                    <h4 class="bg-2">Save Money</h4>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="col-lg-2 col-md-3 mb-md-3 mb-lg-0">-->
        <!--                <div class="banner-features wow fadeIn animated hover-up">-->
        <!--                    <img src="frontend/assets/imgs/theme/icons/feature-6.png" alt="" />-->
        <!--                    <h4 class="bg-6">24/7 Support</h4>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</section>-->

        {{-- product section --}}
        <section class="product-tabs section-padding position-relative wow fadeIn animated">
            <div class="bg-square"></div>
            <div class="container">
                <div class="tab-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                                type="button" role="tab" aria-controls="tab-one" aria-selected="true">
                                Featured
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two"
                                type="button" role="tab" aria-controls="tab-two" aria-selected="false">
                                Popular
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three"
                                type="button" role="tab" aria-controls="tab-three" aria-selected="false">
                                New added
                            </button>
                        </li>
                    </ul>
                    <!--<a href="{{ route('frontend.shop') }}" class="view-more d-none d-md-flex">View More<i-->
                    <!--        class="fi-rs-angle-double-small-right"></i></a>-->
                             <a href="https://visionplus.pk/shop?category=eyeglasses" class="view-more d-none d-md-flex">View More<i
                            class="fi-rs-angle-double-small-right"></i></a>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content wow fadeIn animated" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">
                            @foreach ($featuredProducts as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <!-- updated card for product -->
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('frontend.productDetail', $product) }}">
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                        alt="{{ $product->name }}" loading="lazy"  />

                                                    @if ($product->colors->isNotEmpty() && $product->colors[0]->image)
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/colors/' . $product->colors[0]->image) }}"
                                                            alt="{{ $product->name }}" loading="lazy" />
                                                    @else
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                            alt="{{ $product->name }}" loading="lazy"  />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up quick-view-btn "
                                                    href="{{ route('frontend.quick-view', $product) }}"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                                <form id="add-to-wishlist-{{ $product->id }}"
                                                    action="{{ route('frontend.addToWishList', $product) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                            @if ($product->virtual_try_on_image)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">
                                                        <a aria-label="" class=""
                                                            href="{{ route('virtual.try.on', $product->slug) }}">Try
                                                            On</a></span>
                                                </div>
                                            @endif
                                            @if ($product->discount)
                                                <div class="product-badges product-badges-positionTwo product-badges-mrg">
                                                    <span class="hot">{{ $product->discount }}% Off</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">
                                                    {{ $product->categories->pluck('name')->implode(', ') }}
                                                </a>
                                            </div>
                                            <h2>
                                                <a
                                                    href="{{ route('frontend.productDetail', $product) }}">{{ $product->name }}</a>
                                            </h2>
                                            {{-- <span>{{ $product->discount }}% off</span> --}}

                                            <div class="product-price">
                                                <span>{{ $product->discountprice ?? $product->price }}</span>
                                                @if ($product->discountprice)
                                                    <span class="old-price">{{ $product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="{{ route('frontend.productDetail', $product) }}"><i
                                                        class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- updated card for product end -->
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab one (Featured)-->
                    <div class="tab-pane fade" id="tab-two" role="tabpanel" aria-labelledby="tab-two">
                        <div class="row product-grid-4">
                            @foreach ($popularProducts as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <!-- updated card for product -->
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('frontend.productDetail', $product) }}">
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                        alt="{{ $product->name }}" loading="lazy"  />

                                                    @if ($product->colors->isNotEmpty() && $product->colors[0]->image)
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/colors/' . $product->colors[0]->image) }}"
                                                            alt="{{ $product->name }}" loading="lazy"  />
                                                    @else
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                            alt="{{ $product->name }}" loading="lazy"  />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up quick-view-btn"
                                                    href="{{ route('frontend.quick-view', $product) }}"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                                <form id="add-to-wishlist-{{ $product->id }}"
                                                    action="{{ route('frontend.addToWishList', $product) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                            @if ($product->virtual_try_on_image)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">
                                                        <a aria-label="" class=""
                                                            href="{{ route('virtual.try.on', $product->slug) }}">Try
                                                            On</a></span>
                                                </div>
                                            @endif

                                            @if ($product->discount)
                                                <div class="product-badges product-badges-positionTwo product-badges-mrg">
                                                    <span class="hot">{{ $product->discount }}% Off</span>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">
                                                    {{ $product->categories->pluck('name')->implode(', ') }}
                                                </a>
                                            </div>
                                            <h2>
                                                <a href="{{ route('frontend.productDetail', $product) }}">{{ $product->name }}
                                                </a>
                                            </h2>
                                            {{-- <span>{{ $product->discount }}% off</span> --}}

                                            <div class="product-price">
                                                <span>{{ $product->discountprice ?? $product->price }}</span>
                                                @if ($product->discountprice)
                                                    <span class="old-price">{{ $product->price }} </span>
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="{{ route('frontend.productDetail', $product) }}"><i
                                                        class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab two (Popular)-->
                    <div class="tab-pane fade" id="tab-three" role="tabpanel" aria-labelledby="tab-three">
                        <div class="row product-grid-4">
                            @foreach ($newProducts as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <!-- updated card for product -->
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('frontend.productDetail', $product) }}">
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                        alt="{{ $product->name }}" loading="lazy" />

                                                    @if ($product->colors->isNotEmpty() && $product->colors[0]->image)
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/colors/' . $product->colors[0]->image) }}"
                                                            alt="{{ $product->name }}" loading="lazy"  />
                                                    @else
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                            alt="{{ $product->name }}" loading="lazy" />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up quick-view-btn"
                                                    href="{{ route('frontend.quick-view', $product) }}"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                                <form id="add-to-wishlist-{{ $product->id }}"
                                                    action="{{ route('frontend.addToWishList', $product) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                            @if ($product->virtual_try_on_image)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">
                                                        <a aria-label="" class=""
                                                            href="{{ route('virtual.try.on', $product->slug) }}">Try
                                                            On</a></span>
                                                </div>
                                            @endif
                                            @if ($product->discount)
                                                <div class="product-badges product-badges-positionTwo product-badges-mrg">
                                                    <span class="hot">{{ $product->discount }}% Off</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">
                                                    {{ $product->categories->pluck('name')->implode(', ') }}
                                                </a>
                                            </div>
                                            <h2>
                                                <a
                                                    href="{{ route('frontend.productDetail', $product) }}">{{ $product->name }}</a>
                                            </h2>
                                            {{-- <span>{{ $product->discount }}% off</span> --}}

                                            <div class="product-price">
                                                <span>{{ $product->discountprice ?? $product->price }}</span>
                                                @if ($product->discountprice)
                                                    <span class="old-price">{{ $product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="{{ route('frontend.productDetail', $product) }}"><i
                                                        class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab three (New added)-->
                </div>
                <!--End tab-content-->
            </div>
        </section>

        <!--   Product Cards Section Hero Section -->
        <section class="easysight-hero-section">
            <div class="container">
                <div class="text-center">
                    <h2 class="easysight-hero-title section-title"><span>Fresh</span>Arrivals
                    </h2>
                    <p class="easysight-hero-subtitle">𝐋𝐢𝐦𝐢𝐭𝐞𝐝 𝐒𝐭𝐨𝐜𝐤 — 𝐆𝐫𝐚𝐛 𝐘𝐨𝐮𝐫𝐬 𝐍𝐨𝐰</p>
                </div>
            </div>
        </section>

        <!-- Product Cards Section -->
        <section class="easysight-cards-container">
            <div class="container">
                <div class="row g-4">
                    <!-- Luxury Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="easysight-product-card easysight-card-metal">
                            <div class="easysight-floating-elements">
                                <div class="easysight-floating-circle easysight-circle-1"></div>
                                <div class="easysight-floating-circle easysight-circle-2"></div>
                                <div class="easysight-floating-circle easysight-circle-3"></div>
                            </div>
                            <div class="easysight-card-overlay"></div>

                            <!-- Model Image Container -->
                            <div class="easysight-model-image">

                                <div class="easysight-image-placeholder">
                                    <img src="frontend/assets/imgs/cards/men-img.png"
                                        alt=" men's prescription eyeglasses "
                                        loading="lazy" >

                                </div>
                            </div>

                            <div class="easysight-card-image">
                                <svg width="180" height="180" viewBox="0 0 200 200" fill="none">
                                    <path
                                        d="M50 100C50 100 70 80 100 80C130 80 150 100 150 100C150 100 130 120 100 120C70 120 50 100 50 100Z"
                                        fill="currentColor" opacity="0.3" />
                                    <circle cx="75" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <circle cx="125" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <line x1="95" y1="100" x2="105" y2="100"
                                        stroke="currentColor" stroke-width="3" opacity="0.5" />
                                </svg>
                            </div>
                            <div class="easysight-card-content">
                                <div>
                                    <h3 class="easysight-card-title-text text-center">Men</h3>
                                </div>
                                <div>
                                    <a href="{{ url('/shop') }}?category=eyeglasses&type=menss-eyeglasses"
                                        class="easysight-shop-btn">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chill Vibes Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="easysight-product-card easysight-card-metal">
                            <div class="easysight-floating-elements">
                                <div class="easysight-floating-circle easysight-circle-1"></div>
                                <div class="easysight-floating-circle easysight-circle-2"></div>
                                <div class="easysight-floating-circle easysight-circle-3"></div>
                            </div>
                            <div class="easysight-card-overlay"></div>

                            <!-- Model Image Container -->
                            <div class="easysight-model-image">

                                <div class="easysight-image-placeholder">
                                    <img src="frontend/assets/imgs/cards/women-img.png"
                                        alt=" women's eyeglasses "
                                        loading="lazy">

                                </div>
                            </div>

                            <div class="easysight-card-image">
                                <svg width="180" height="180" viewBox="0 0 200 200" fill="none">
                                    <path
                                        d="M50 100C50 100 70 80 100 80C130 80 150 100 150 100C150 100 130 120 100 120C70 120 50 100 50 100Z"
                                        fill="currentColor" opacity="0.3" />
                                    <circle cx="75" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <circle cx="125" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <line x1="95" y1="100" x2="105" y2="100"
                                        stroke="currentColor" stroke-width="3" opacity="0.5" />
                                </svg>
                            </div>
                            <div class="easysight-card-content">
                                <div>
                                    <h3 class="easysight-card-title-text text-center">WOMEN</h3>
                                    <!-- <p class="easysight-card-subtitle">The Premium Feel</p> -->
                                </div>
                                <div>
                                    <a href="{{ url('/shop') }}?category=eyeglasses&type=womens-eyeglasses"
                                        class="easysight-shop-btn">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bold Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="easysight-product-card easysight-card-metal">
                            <div class="easysight-floating-elements">
                                <div class="easysight-floating-circle easysight-circle-1"></div>
                                <div class="easysight-floating-circle easysight-circle-2"></div>
                                <div class="easysight-floating-circle easysight-circle-3"></div>
                            </div>
                            <div class="easysight-card-overlay"></div>

                            <!-- Model Image Container -->
                            <div class="easysight-model-image">

                                <div class="easysight-image-placeholder">
                                    <img src="frontend/assets/imgs/cards/kids-img.png"
                                        alt=" eyewear for children"
                                        loading="lazy" >

                                </div>
                            </div>

                            <div class="easysight-card-image">
                                <svg width="180" height="180" viewBox="0 0 200 200" fill="none">
                                    <path
                                        d="M50 100C50 100 70 80 100 80C130 80 150 100 150 100C150 100 130 120 100 120C70 120 50 100 50 100Z"
                                        fill="currentColor" opacity="0.3" />
                                    <circle cx="75" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <circle cx="125" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <line x1="95" y1="100" x2="105" y2="100"
                                        stroke="currentColor" stroke-width="3" opacity="0.5" />
                                </svg>
                            </div>
                            <div class="easysight-card-content">
                                <div>
                                    <h3 class="easysight-card-title-text text-center">Kids</h3>
                                    <!-- <p class="easysight-card-subtitle">The Premium Feel</p> -->
                                </div>
                                <div>
                                    <a href="{{ url('/shop') }}?category=eyeglasses&type=kids-eyeglasses"
                                        class="easysight-shop-btn">
                                        Shop Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metal Shine Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="easysight-product-card easysight-card-metal">
                            <div class="easysight-floating-elements">
                                <div class="easysight-floating-circle easysight-circle-1"></div>
                                <div class="easysight-floating-circle easysight-circle-2"></div>
                                <div class="easysight-floating-circle easysight-circle-3"></div>
                            </div>
                            <div class="easysight-card-overlay"></div>

                            <!-- Model Image Container -->
                            <div class="easysight-model-image">

                                <div class="easysight-image-placeholder">
                                    <img src="frontend/assets/imgs/cards/model-card-img.png"
                                        alt="blue light blocking screen glasses"
                                        loading="lazy" >

                                </div>
                            </div>

                            <div class="easysight-card-image">
                                <svg width="180" height="180" viewBox="0 0 200 200" fill="none">
                                    <path
                                        d="M50 100C50 100 70 80 100 80C130 80 150 100 150 100C150 100 130 120 100 120C70 120 50 100 50 100Z"
                                        fill="currentColor" opacity="0.3" />
                                    <circle cx="75" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <circle cx="125" cy="100" r="20" fill="none" stroke="currentColor"
                                        stroke-width="2" opacity="0.7" />
                                    <line x1="95" y1="100" x2="105" y2="100"
                                        stroke="currentColor" stroke-width="3" opacity="0.5" />
                                </svg>
                            </div>
                            <div class="easysight-card-content">
                                <div>
                                    <h3 class="easysight-card-title-text text-center">
                                        Lenses
                                    </h3>
                                </div>
                                <div>
                                    <a href="{{ url('/shop') }}?category=contact-lenses"
                                        class="easysight-shop-btn">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="popular-categories section-padding mt-15 mb-25">
            <div class="container wow fadeIn animated">
                <h3 class="section-title mb-20"><span>Popular</span> Categories</h3>
                <div class="carausel-6-columns-cover position-relative">
                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-arrows">
                    </div>
                    <div class="carausel-6-columns" id="carausel-6-columns">
                        @foreach ($popularProducts as $product)
                            <div class="card-1">
                                <figure class="img-hover-scale overflow-hidden">
                                    <a href="{{ route('frontend.productDetail', $product) }}"><img
                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                            alt="" loading="lazy" /></a>
                                </figure>
                                <h5><a href="{{ route('frontend.productDetail', $product) }}">{{ $product->name }}</a>
                                </h5>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container wow fadeIn animated">
                <h3 class="section-title mb-20"><span>New</span> Arrivals</h3>
                <div class="carausel-6-columns-cover position-relative">
                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-2-arrows">
                    </div>
                    <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">
                        @foreach ($newProducts as $product)
                            <div class="product-cart-wrap small hover-up">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="{{ route('frontend.productDetail', $product) }}">
                                            <img class="default-img"
                                                src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                alt="{{ $product->name }}" loading="lazy" />

                                            @if ($product->colors->isNotEmpty() && $product->colors[0]->image)
                                                <img class="hover-img"
                                                    src="{{ asset('uploads/products/colors/' . $product->colors[0]->image) }}"
                                                    alt="{{ $product->name }}" loading="lazy" />
                                            @else
                                                <img class="hover-img"
                                                    src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                    alt="{{ $product->name }}" loading="lazy" />
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product-action-1">
                                        <a aria-label="Quick view" class="action-btn hover-up quick-view-btn"
                                            href="{{ route('frontend.quick-view', $product) }}" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal" data-product-id="{{ $product->id }}">
                                            <i class="fi-rs-eye"></i>
                                        </a>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                            href="javascript:void(0);"
                                            onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();">
                                            <i class="fi-rs-heart"></i>
                                        </a>
                                        <form id="add-to-wishlist-{{ $product->id }}"
                                            action="{{ route('frontend.addToWishList', $product) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">{{ $product->status }}</span>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <h2>
                                        <a
                                            href="{{ route('frontend.productDetail', $product) }}">{{ $product->name }}</a>
                                    </h2>
                                    {{-- <div class="rating-result" title="90%">
                                        <span> </span>
                                    </div> --}}
                                    <div class="product-price">
                                        <div class="product-price">
                                            <span>{{ $product->discountprice ?? $product->price }}</span>
                                            @if ($product->discountprice)
                                                <span class="old-price">{{ $product->price }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="deals section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 deal-co">
                        <div class="deal wow fadeIn animated mb-md-4 mb-sm-4 mb-lg-0"
                            style="background-image: url('frontend/assets/imgs/banner/menu-banner-7.jpg');">

                            <div class="deal-bottom  text-center">
                                <h1 class="sunglass-heading">Men Sunglasses</h1>
                                <!-- <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"></div> -->
                                <a href="{{ url('/shop') }}?category=sunglasses&type=mens-sunglasses" class="sunglass-btn">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 deal-co">
                        <div class="deal wow fadeIn animated"
                            style="background-image: url('frontend/assets/imgs/banner/menu-banner-8.jpg');">
                            <div class="deal-bottom  text-center">
                                <h2 class="sunglass-heading">Women Sunglasses</h2>
                                <!-- <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"></div> -->
                                <a href="{{ url('/shop') }}?category=sunglasses&type=womens-sunglasses" class="sunglass-btn">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <h3 class="section-title mb-20 wow fadeIn animated">
                    <span>Featured</span> Brands
                </h3>
                <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows">
                    </div>
                    <div class="carausel-6-columns text-center" id="carausel-6-columns-3">
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/ziesslogo.jpg" alt="ziesslogo" loading="lazy" />
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/privologo.png" alt="privologo" loading="lazy"/>
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/freshlook.png" alt="freshlook" loading="lazy"/>
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/freshkonlogo.png" alt="freshkonlogo" loading="lazy"  />
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/cooperlogo.jpg" alt="cooperlogo" loading="lazy" />
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/optianologo.jpg" alt="optianologo" loading="lazy"  />
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover-brand img-grey-hover"
                                src="frontend/assets/imgs/banner/hi-qlogo.png" alt="hi-qlogo" loading="lazy" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-grey-9 section-padding">
            <div class="container pt-25 pb-25">
                <div class="heading-tab d-flex">
                    <div class="heading-tab-left wow fadeIn animated">
                        <h3 class="section-title mb-20">
                            <span>Monthly</span> Best Sell
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 d-none d-lg-flex">
                        <div class="banner-img style-2 wow fadeIn animated">
                            <img src="frontend/assets/imgs/banner/contact-lens-model.png" alt="contact-lens-model" loading="lazy"  />
                            <div class="banner-text">
                                <a href="https://visionplus.pk/shop?category=contact-lenses" class="text-white">Shop Now <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                id="carausel-4-columns-arrows"></div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                @foreach ($products as $product)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('frontend.productDetail', $product) }}">
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                        alt="{{ $product->name }}" loading="lazy" />

                                                    @if ($product->colors->isNotEmpty() && $product->colors[0]->image)
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/colors/' . $product->colors[0]->image) }}"
                                                            alt="{{ $product->name }}" loading="lazy" />
                                                    @else
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                            alt="{{ $product->name }}" loading="lazy" />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up quick-view-btn"
                                                    href="{{ route('frontend.quick-view', $product) }}"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0);"
                                                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-{{ $product->id }}').submit();">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                                <form id="add-to-wishlist-{{ $product->id }}"
                                                    action="{{ route('frontend.addToWishList', $product) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                            @if ($product->virtual_try_on_image)
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">
                                                        <a aria-label="" class=""
                                                            href="{{ route('virtual.try.on', $product->slug) }}">Try
                                                            On</a></span>
                                                </div>
                                            @endif
                                            {{-- @if ($product->discount)
                                            <div class="product-badges product-badges-positionTwo product-badges-mrg">
                                                <span class="hot">{{ $product->discount }}% Off</span>
                                            </div>
                                            @endif --}}
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">
                                                    {{ $product->categories->pluck('name')->implode(', ') }}
                                                </a>
                                            </div>
                                            <h2>
                                                <a
                                                    href="{{ route('frontend.productDetail', $product) }}">{{ $product->name }}</a>
                                            </h2>

                                            @if ($product->discount)
                                                <span>{{ $product->discount }}% off</span>
                                            @endif

                                            <div class="product-price">
                                                <div class="product-price">
                                                    <span>{{ $product->discountprice ?? $product->price }}</span>
                                                    @if ($product->discountprice)
                                                        <span class="old-price">{{ $product->price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="{{ route('frontend.productDetail', $product) }}"><i
                                                        class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--End Col-lg-9-->
                </div>
            </div>
        </section>

        <section class="easysight-hero-section">
            <div class="container">
                <div class="text-center">
                    <h2 class="easysight-hero-title section-title"><span>𝐋𝐢𝐦𝐢𝐭𝐞𝐝-</span>𝐄𝐝𝐢𝐭𝐢𝐨𝐧</h2>
                    <p class="easysight-hero-subtitle"> 𝐄𝐱𝐩𝐥𝐨𝐫𝐞 𝐓𝐡𝐞 𝐋𝐚𝐭𝐞𝐬𝐭 𝐓𝐫𝐞𝐧𝐝𝐬 𝐃𝐨𝐧’𝐭
                        𝐌𝐢𝐬𝐬 𝐎𝐮𝐭!

                    </p>
                </div>
            </div>
        </section>

        <section class="new-card-section">
            <div class="prod-grid">
                <!-- Card 1 -->
                <div class="prod-card fader-effect delay-1">
                    <img src="frontend/assets/imgs/cards/new-card-img-2.jpg"
                        alt="Limited edition men's designer sunglasses by VisionPlus – stylish UV protection"
                        loading="lazy"  class="prod-img prod-img-2">
                    <div class="prod-overlay"></div>
                    <div class="prod-shine"></div>
                    <!-- <div class="prod-badge">Trending</div> -->
                    <div class="prod-btn-wrap">
                        <!--<a href="{{ url('/shop') }}?category=sunglasses&type=mens-sunglasses" class="prod-btn">Shop Now</a>-->
                        <a href="https://visionplus.pk/product-detail/rayban-wayfarer" class="prod-btn">Shop Now</a>
                        
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="prod-card fader-effect delay-2">
                    <img src="frontend/assets/imgs/cards/new-card-img.png"
                        alt="Limited edition women's prescription eyeglasses – elegant frames by VisionPlus"
                        loading="lazy" class="prod-img prod-img-2">
                    <div class="prod-overlay"></div>
                    <div class="prod-shine"></div>
                    <!-- <div class="prod-badge">New Arrival</div> -->
                    <div class="prod-btn-wrap">
                        <!--<a href="{{ url('/shop') }}?category=eyeglasses&type=womens-eyeglasses" class="prod-btn">Shop Now</a>-->
                        <a href="https://visionplus.pk/product-detail/urban-bridge" class="prod-btn">Shop Now</a>
                    </div>
                </div>

                <!-- card-3 -->
                <div class="prod-card fader-effect">
                    <img src="frontend/assets/imgs/cards/new-card-img-4.jpg"
                        alt="Men's Clubmaster-style eyeglasses – limited edition VisionPlus frame" loading="lazy" 
                        class="prod-img prod-img-2">
                    <div class="prod-overlay"></div>
                    <div class="prod-shine"></div>
                    <!-- <div class="prod-badge">Premium</div> -->
                    <div class="prod-btn-wrap">
                        <!--<a href="{{ url('/shop') }}?category=eyeglasses&type=mens-eyeglasses" class="prod-btn">Shop Now</a>-->
                        <a href="https://visionplus.pk/product-detail/clubmaster-silver" class="prod-btn">Shop Now</a>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="prod-card fader-effect delay-3">
                    <img src="frontend/assets/imgs/cards/new-card-img-1.jpg"
                        alt="Limited edition women's fashion sunglasses – UV-protected by VisionPlus" loading="lazy"
                        class="prod-img prod-img-2">
                    <div class="prod-overlay"></div>
                    <div class="prod-shine"></div>
                    <!-- <div class="prod-badge">Best Seller</div> -->
                    <div class="prod-btn-wrap">
                        <!--<a href="{{ url('/shop') }}?category=sunglasses&type=womens-sunglasses" class="prod-btn">Shop Now</a>-->
                        <a href="https://visionplus.pk/product-detail/chanel-ladies" class="prod-btn">Shop Now</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    
        <!-- Add this script to handle the preloader -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle menu expand/collapse
            document.querySelectorAll('.menu-expand').forEach(expand => {
                expand.addEventListener('click', function (e) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    parent.classList.toggle('active');

                    // Close other open menus at the same level
                    if (parent.classList.contains('active')) {
                        const siblings = parent.parentElement.querySelectorAll(
                            '.menu-item-has-children');
                        siblings.forEach(sib => {
                            if (sib !== parent) {
                                sib.classList.remove('active');
                            }
                        });
                    }
                });
            });

            // Highlight current category
            const currentCategory = "{{ request()->input('category') }}";
            if (currentCategory) {
                document.querySelectorAll(`a[href*="${currentCategory}"]`).forEach(link => {
                    let parent = link.closest('.menu-item-has-children');
                    while (parent) {
                        parent.classList.add('active');
                        parent = parent.parentElement.closest('.menu-item-has-children');
                    }
                    link.classList.add('active');
                });
            }
        });
    </script>
@endsection
