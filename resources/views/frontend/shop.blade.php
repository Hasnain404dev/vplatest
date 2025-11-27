@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
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
                                <p> We found <strong class="text-brand">{{ $products->total() }}</strong> items for you!</p>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> {{ request('show', 12) }} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ request('show') == 50 ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['show' => 50]) }}">50</a></li>
                                            <li><a class="{{ request('show') == 100 ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['show' => 100]) }}">100</a></li>
                                            <li><a class="{{ request('show') == 150 ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['show' => 150]) }}">150</a></li>
                                            <li><a class="{{ request('show') == 200 ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['show' => 200]) }}">200</a></li>
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
                                                @if (request('sort') == 'featured')
                                                    Featured
                                                @elseif(request('sort') == 'price_low')
                                                    Price: Low to High
                                                @elseif(request('sort') == 'price_high')
                                                    Price: High to Low
                                                @elseif(request('sort') == 'date')
                                                    Release Date
                                                @elseif(request('sort') == 'popular')
                                                    Popular
                                                @elseif(request('sort') == 'new')
                                                    New
                                                @else
                                                    Featured
                                                @endif
                                                <i class="fi-rs-angle-small-down"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ request('sort') == 'featured' || !request('sort') ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}">Featured</a>
                                            </li>
                                            <li><a class="{{ request('sort') == 'price_low' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">Price:
                                                    Low to High</a></li>
                                            <li><a class="{{ request('sort') == 'price_high' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">Price:
                                                    High to Low</a></li>
                                            <li><a class="{{ request('sort') == 'date' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'date']) }}">Release
                                                    Date</a></li>
                                            <li><a class="{{ request('sort') == 'popular' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">Popular</a>
                                            </li>
                                            <li><a class="{{ request('sort') == 'new' ? 'active' : '' }}"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'new']) }}">New
                                                    Arrivals</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-grid-3">
                            @foreach ($products as $product)
                                <div class="col-lg-3 col-md-4">
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
                                                            alt="{{ $product->name }}"  loading="lazy"  />
                                                    @else
                                                        <img class="hover-img"
                                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                                            alt="{{ $product->name }}"  loading="lazy" />
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
                                                    action="{{ route('frontend.addToWishList', $product) }}" method="POST"
                                                    style="display: none;">
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
                                            <h2><a
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
                        <!--pagination-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            {{ $products->onEachSide(1)->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
