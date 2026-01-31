<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
   <meta charset="utf-8" />
    <title>
        Buy Eyeglasses, Blue Light Glasses, Lenses & Sunglasses Online
    </title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="description"
        content="Shop premium prescription glasses, contact lenses, and stylish sunglasses with virtual try-on. Trusted by thousands across Pakistan for fast delivery & expert eye care." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Canonical URL -->
    <link rel="canonical" href="https://visionplus.pk/" />

        <style>
            html, body { overflow-x: hidden; }
            .container, .row { max-width: 100%; }
            img, video { max-width: 100%; height: auto; }
            .header-wrap, .mobile-header-wrapper-inner { width: 100%; }
        </style>

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->

    <meta property="og:title" content="VisionPlusOpticians Pakistan | Stylish Eyewear & Expert Eye Care" />
    <meta property="og:description" content="Pakistan’s #1 online optical store for premium glasses, lenses, and sunglasses. Free delivery, expert eye care, and virtual try-on available." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://visionplus.pk/" />
    <!--<meta property="og:image" content="https://visionplus.pk/evara-frontend/assets/imgs/banner/banner.jpg" />-->

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="VisionPlusOpticians Pakistan | Stylish Eyewear & Expert Eye Care" />
    <meta name="twitter:description"
        content="Pakistan’s #1 online optical store for glasses, lenses, and sunglasses. Try online, buy with ease." />
    <!--<meta name="twitter:image" content="https://visionplus.pk/evara-frontend/assets/imgs/banner/banner.jpg" />-->

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js" defer></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Preconnect for Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Preload + Load only required weights -->
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Spartan:wght@400;600&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Spartan:wght@400;600&display=swap" media="all">
<noscript>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&family=Spartan:wght@400;600&display=swap">
</noscript>


    @stack('head')
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/imgs/theme/vp_favicon.png')}}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <noscript><link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}"></noscript>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-03LLVGZMRD"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-03LLVGZMRD');
</script>

    <!-- Custom CSS -->
    <link rel="preload" href="{{ asset('frontend/assets/css/custom.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}"></noscript>

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custome.css') }}" />
    <!--schema-->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Optician",
  "name": "Vision Plus Optical",
  "url": "https://visionplus.pk",
  "logo": "https://visionplus.pk/frontend/assets/imgs/theme/bluelogo-vision.png",
  "image": "https://visionplus.pk/frontend/assets/imgs/theme/bluelogo-vision.png",
  "email": "visionplus492@gmail.com",
  "telephone": "+92-339-1339339",
  "sameAs": [
    "https://www.facebook.com/VisionPlusOpticiansPK",
    "https://www.instagram.com/visionplusopticianspk"
  ],
  "address": [
    {
      "@@type": "PostalAddress",
      "streetAddress": "Sheraz Plaza, Hali Road, Gulberg 2",
      "addressLocality": "Lahore",
      "addressCountry": "PK"
    },
    {
      "@@type": "PostalAddress",
      "streetAddress": "Township",
      "addressLocality": "Lahore",
      "addressCountry": "PK"
    },
    {
      "@@type": "PostalAddress",
      "streetAddress": "Iqbal Town",
      "addressLocality": "Lahore",
      "addressCountry": "PK"
    }
  ],
  "openingHoursSpecification": [
    {
      "@@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
      ],
      "opens": "10:00",
      "closes": "22:00"
    }
  ]
}
</script>

</head>

<body>

  
    <!-- Quick view -->
    <div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <!-- Content will be loaded here via AJAX -->
                    <div class="text-center py-5">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- navbar start -->
    <header class="header-area header-style-1 header-height-2">
        <div class="header-top header-top-ptb-1 d-none d-lg-block ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><i class="fi-rs-smartphone"></i> <a href="#">042 35197464</a></li>
                                <li>
                                    <i class="fi-rs-marker"></i>
                                    <a href="{{ route('frontend.contactUs') }}">
                                        <span data-lang-en="Our location" data-lang-ur="ہمارا پتہ">Our location</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>👁️ Book Your Eye Test Today!</li>
                                    <li>🚚 Free Shipping Across Pakistan!</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Language button -->

                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                <!--<li>-->
                                <!--    <a class="language-dropdown-active" href="#" onclick="setLanguage('en')">-->
                                <!--        <i class="fi-rs-world"></i> English-->
                                <!--        <i class="fi-rs-angle-small-down"></i>-->
                                <!--    </a>-->
                                <!--    <ul class="language-dropdown">-->
                                <!--        <li>-->
                                <!--            <a href="#" onclick="setLanguage('ur')" style="font-size: larger;">-->
                                <!--                <img src="assets/imgs/theme/flag-fr.png"-->
                                <!--                    alt="Flag Icon" loading="lazy">-->
                                <!--                اردو-->
                                <!--            </a>-->
                                <!--        </li>-->
                                <!--    </ul>-->
                                <!--</li>-->
                                <li>
                                    @guest
                                        @if (Route::has('login'))
                                            <i class="fi-rs-user"></i><a href="{{ route('login') }}">
                                                <span data-lang-en="Log In" data-lang-ur="لاگ اِن">Log In</span>
                                            </a>
                                        @endif

                                        @if (Route::has('register'))
                                            <i class="fi-rs-user"></i><a href="{{ route('register') }}">
                                                <span data-lang-en="Sign Up" data-lang-ur="سائن اپ">Sign Up</span>
                                            </a>
                                        @endif
                                    @else
                                    <li class="dropdown">
                                        <i class="fi-rs-user"></i><a id="navbarDropdown" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <span>{{ Auth::user()->name }}</span>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            @if (Auth::user()->getRawOriginal('type') == 1)
                                                <a class="dropdown-item" href="{{ url('/admin/dashboard') }}">
                                                    <span data-lang-en="Dashboard"
                                                        data-lang-ur="ڈیش بورڈ">Dashboard</span>
                                                </a>
                                            @else
                                                <a class="dropdown-item" href="{{ url('/home') }}">
                                                    <span data-lang-en="Home" data-lang-ur="ہوم">Home</span>
                                                </a>
                                            @endif

                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <span data-lang-en="Logout" data-lang-ur="لاگ آؤٹ">Logout</span>
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Language button End -->
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ route('frontend.home') }}"><img
                                src="{{ asset('frontend/assets/imgs/theme/bluelogo-vision.png') }}" alt="logo" loading="eager" ></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ route('frontend.search') }}" method="GET">
                                <select class="select-active" name="category">
                                    <option value="">All Categories</option>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="query" id="search-input"
                                    placeholder="Search for products..." autocomplete="off"
                                    value="{{ request('query') }}" />
                            </form>

                            <!-- Search results dropdown container -->
                            <div id="search-results-dropdown" class="search-results-dropdown" style="display: none;">
                            </div>
                        </div>

                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-icon-2">
                                    <a href="{{ route('frontend.wishList') }}">
                                        <img class="svgInject" alt="Wishlist"
                                            src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                        <span class="pro-count blue wishlist-count">
                                            @if (auth()->check())
                                                {{ \App\Models\Wishlist::where('user_id', auth()->id())->count() }}
                                            @else
                                                {{ \App\Models\Wishlist::where('session_id', session()->getId())->count() }}
                                            @endif
                                        </span>
                                    </a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ route('frontend.cart') }}">
                                        <img alt="Evara"
                                            src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                        <span class="pro-count blue cart-count">
                                            @if (auth()->check())
                                                {{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}
                                            @else
                                                {{ \App\Models\Cart::where('session_id', session()->getId())->sum('quantity') }}
                                            @endif
                                        </span>
                                    </a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            @php
                                                if (auth()->check()) {
                                                    $cartItems = \App\Models\Cart::where('user_id', auth()->id())
                                                        ->with('product')
                                                        ->take(2)
                                                        ->get();
                                                } else {
                                                    $cartItems = \App\Models\Cart::where(
                                                        'session_id',
                                                        session()->getId(),
                                                    )
                                                        ->with('product')
                                                        ->take(2)
                                                        ->get();
                                                }

                                                $cartTotal = 0;
                                            @endphp

                                            @forelse($cartItems as $item)
                                                @php $cartTotal += $item->total_price; @endphp
                                                <li>
                                                    <div class="shopping-cart-img">
                                                        <a
                                                            href="{{ route('frontend.productDetail', $item->product) }}">
                                                            <img alt="{{ $item->product->name }}"
                                                                src="{{ asset('uploads/products/' . $item->product->main_image) }}" />
                                                        </a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4>
                                                            <a
                                                                href="{{ route('frontend.productDetail', $item->product) }}">{{ Str::limit($item->product->name, 20) }}</a>
                                                        </h4>
                                                        <h4><span>{{ $item->quantity }} × </span>Rs.
                                                            {{ number_format($item->product->price, 2) }}
                                                        </h4>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <a href="#" class="remove-from-cart-header"
                                                            data-id="{{ $item->id }}"><i
                                                                class="fi-rs-cross-small"></i></a>
                                                    </div>
                                                </li>
                                            @empty
                                                <li>
                                                    <div class="text-center p-2">
                                                        Your cart is empty
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>Total <span>Rs. {{ number_format($cartTotal, 2) }}</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="{{ route('frontend.cart') }}" class="outline">View
                                                    cart</a>
                                                <a href="{{ route('frontend.checkout') }}">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between  position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ route('frontend.home') }}"><img
                                src="{{ asset('frontend/assets/imgs/theme/bluelogo-vision.png') }}" alt="logo" loading="eager"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <!-- <a class="categori-button-active" href="#">
                            <span class="fi-rs-apps"></span>Purchse Guide
                        </a> -->
                            <a class="active" href="{{ route('frontend.perchaseGuide') }}">
                                <span class="fi-rs-apps"></span>
                               <span data-lang-en="Purchase Guide" data-lang-ur="خریداری کی رہنمائی">Order Guide</span>
                            </a>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    <li>
                                        <a class="active" href="{{ route('frontend.home') }}">
                                            <span data-lang-en="Home" data-lang-ur="ہوم">Home</span>
                                        </a>
                                    </li>

                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <li class="position-static">
                                                <a href="{{ route('frontend.shop', ['category' => $category->slug]) }}">
                                                    <span data-lang-en="{{ $category->name }}"
                                                        data-lang-ur="{{ $category->name_ur ?? $category->name }}">
                                                        {{ $category->name }}
                                                    </span>
                                                    @if ($category->children->count())
                                                        <i class="fi-rs-angle-down"></i>
                                                    @endif
                                                </a>

                                                @if ($category->children->count())
                                                    <ul class="mega-menu">
                                                        @foreach ($category->children->chunk(ceil($category->children->count() / 3)) as $chunk)
                                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                                @foreach ($chunk as $subcategory)
                                                                    <a class="menu-title"
                                                                        href="{{ route('frontend.shop', ['category' => $category->slug, 'type' => $subcategory->slug]) }}">
                                                                        {{ $subcategory->name }}
                                                                    </a>
                                                                    <ul>
                                                                        @foreach ($subcategory->children as $child)
                                                                            <li>
                                                                                <a
                                                                                    href="{{ route('frontend.shop', ['category' => $category->slug, 'type' => $child->slug]) }}">
                                                                                    {{ $child->name }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endforeach
                                                            </li>
                                                        @endforeach

                                                        <!-- Banner areas -->
                                                        <li class="sub-mega-menu sub-mega-menu-width-34">
                                                            <div class="menu-banner-wrap">
                                                                <!-- Your banner content -->
                                                            </div>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        <p><i class="fi-rs-headset"></i><span>Hotline</span>0339-1339339</p>
                    </div>
                    <p class="mobile-promotion">Free Shipping Across Pakistan</p>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ route('frontend.wishList') }}">
                                    <img class="svgInject" alt="Wishlist"
                                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count blue wishlist-count">
                                        @if (auth()->check())
                                            {{ \App\Models\Wishlist::where('user_id', auth()->id())->count() }}
                                        @else
                                            {{ \App\Models\Wishlist::where('session_id', session()->getId())->count() }}
                                        @endif
                                    </span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('frontend.cart') }}">
                                    <img alt="Evara"
                                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count blue cart-count">
                                        @if (auth()->check())
                                            {{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}
                                        @else
                                            {{ \App\Models\Cart::where('session_id', session()->getId())->sum('quantity') }}
                                        @endif
                                    </span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        @php
                                            if (auth()->check()) {
                                                $cartItems = \App\Models\Cart::where('user_id', auth()->id())
                                                    ->with('product')
                                                    ->take(2)
                                                    ->get();
                                            } else {
                                                $cartItems = \App\Models\Cart::where('session_id', session()->getId())
                                                    ->with('product')
                                                    ->take(2)
                                                    ->get();
                                            }

                                            $cartTotal = 0;
                                        @endphp

                                        @forelse($cartItems as $item)
                                            @php $cartTotal += $item->total_price; @endphp
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="{{ route('frontend.productDetail', $item->product) }}">
                                                        <img alt="{{ $item->product->name }}"
                                                            src="{{ asset('uploads/products/' . $item->product->main_image) }}" />
                                                    </a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4>
                                                        <a
                                                            href="{{ route('frontend.productDetail', $item->product) }}">{{ Str::limit($item->product->name, 20) }}</a>
                                                    </h4>
                                                    <h4><span>{{ $item->quantity }} × </span>Rs.
                                                        {{ number_format($item->product->price, 2) }}
                                                    </h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#" class="remove-from-cart-header"
                                                        data-id="{{ $item->id }}"><i
                                                            class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>
                                        @empty
                                            <li>
                                                <div class="text-center p-2">
                                                    Your cart is empty
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>Rs. {{ number_format($cartTotal, 2) }}</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{ route('frontend.cart') }}" class="outline">View
                                                cart</a>
                                            <a href="{{ route('frontend.checkout') }}">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-mid"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ route('frontend.home') }}"><img
                            src="{{ asset('frontend/assets/imgs/theme/bluelogo-vision.png') }}" alt="logo" loading="eager"></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="{{ route('frontend.search') }}" method="GET">
                        <input type="text" name="query" id="search-input" placeholder="Search for products..."
                            autocomplete="off" value="{{ request('query') }}" />
                    </form>
                    <!-- This dropdown must be immediately after the form -->
                    <div class="search-results-dropdown" style="display: none;"></div>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <div class="main-categori-wrap mobile-header-border">
                        <a class="active" href="{{ route('frontend.perchaseGuide') }}"><span
                                class="fi-rs-apps"></span>Purchase
                            Guide</a>


                    </div>
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children"><span class="menu-expand"></span>
                                <a href="{{ route('frontend.home') }}">Home</a>

                            </li>

                            @if(isset($categories) && $categories->count() > 0)
                                @foreach($categories as $category)
                                    <li class="menu-item-has-children">
                                        <span class="menu-expand"></span>
                                        <a href="{{ route('frontend.shop', ['category' => $category->slug]) }}">
                                            {{ $category->name }}
                                        </a>

                                        @if ($category->children->count())
                                            <ul class="dropdown">
                                                @foreach ($category->children as $subcategory)
                                                    <li
                                                        class="@if ($subcategory->children->count()) menu-item-has-children @endif">
                                                        @if ($subcategory->children->count())
                                                            <span class="menu-expand"></span>
                                                        @endif
                                                        <a
                                                            href="{{ route('frontend.shop', ['category' => $category->slug, 'type' => $subcategory->slug]) }}">
                                                            {{ $subcategory->name }}
                                                        </a>

                                                        @if ($subcategory->children->count())
                                                            <ul class="dropdown">
                                                                @foreach ($subcategory->children as $child)
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('frontend.shop', ['category' => $category->slug, 'type' => $child->slug]) }}">
                                                                            {{ $child->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif


                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info mt-30">
                        <a href="{{ route('frontend.contactUs') }}"> Our location </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="{{ route('frontend.aboutUs') }}"> About us </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="{{ route('login') }}">Log In / Sign Up </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#">+92 339 1339339 </a>
                    </div>
                </div>
                <div class="mobile-social-icon">
                    <h5 class="mb-15 text-grey-4">Follow Us</h5>
                    <!--<a href="https://www.facebook.com/VisionPlusOpticianPK"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook.svg') }}" alt="facebook logo"></a>-->
                    <!-- <a href="#"><img src="assets/imgs/theme/icons/icon-twitter.svg" alt=""></a> -->
                    <!--<a href="#"><img src="assets/imgs/theme/icons/icon-instagram.svg" alt=""></a>-->
                    <!--<a href="#"><img src="assets/imgs/theme/icons/icon-pinterest.svg" alt=""></a>-->
                    <!--<a href="#"><img src="assets/imgs/theme/icons/icon-youtube.svg" alt=""></a>-->
                    <a href="https://www.facebook.com/VisionPlusOpticianPK" target="_blank">
                        <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook.svg') }}"
                            alt="Facebook logo" loading="lazy" />
                    </a>
                    <a href="https://www.instagram.com/visionplusopticianspk/" target="_blank">
                        <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram.svg') }}"
                            alt="Instagram logo" loading="lazy" />
                    </a>
                    <a href="https://www.youtube.com/@@VisionPlusOptician" target="_blank">
                        <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube.svg') }}"
                            alt="YouTube logo"  />
                    </a>

                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <footer class="main">
        <section class="newsletter p-30 text-white wow fadeIn animated">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-md-3 mb-lg-0">
                        <div class="row align-items-center">
                            <div class="col flex-horizontal-center">
                                {{-- <img class="icon-email"
                                    src="{{ asset('frontend/assets/imgs/theme/icons/icon-email.svg') }}" alt="" />
                                <h4 class="font-size-20 mb-0 ml-3"></h4> --}}
                            </div>
                            <div class="col my-4 my-md-0 des">
                                {{-- <h5 class="font-size-15 ml-4 mb-0">
                                    <strong>
                                        </strong>
                                </h5> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <!-- Subscribe Form -->
                        <form class="form-subcriber d-flex wow fadeIn animated">
                            {{-- <input type="email" class="form-control bg-white font-small"
                                placeholder="Enter your email" />
                            <button class="btn bg-dark text-white" type="submit">
                                Subscribe
                            </button> --}}
                        </form>
                        <!-- End Subscribe Form -->
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding footer-mid">
            <div class="container pt-15 pb-20">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="widget-about font-md mb-md-5 mb-lg-0">
                            <div class="logo logo-width-1 wow fadeIn animated">
                                <a href="{{ route('frontend.home') }}"><img src="{{ asset('frontend/assets/imgs/theme/bluelogo-vision.png') }}"
                                        alt="logo" /></a>
                            </div>
                            <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">
                                Contact
                            </h5>
                            <p class="wow fadeIn animated">
                                <strong>Address: </strong> Hali Rd, Gulberg 2, Lahore
                            </p>
                            <p class="wow fadeIn animated">
                                <strong>Phone: </strong>+92 339 1339339
                            </p>
                            <p class="wow fadeIn animated">
                                <strong>Hours: </strong>10:00 AM - 10:00 PM, Mon - Sat
                            </p>
                            <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">
                                Follow Us
                            </h5>
                            <div class="mobile-social-icon wow fadeIn animated mb-sm-5 mb-md-0">
                               <a href="https://www.facebook.com/VisionPlusOpticianPK" target="_blank">
  <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook.svg') }}" alt="Facebook logo" />
</a>
<a href="https://www.instagram.com/visionplusopticianspk/" target="_blank">
  <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram.svg') }}" alt="Instagram logo" loading="lazy"/>
</a>
<a href="https://www.youtube.com/@@VisionPlusOptician" target="_blank">
  <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube.svg') }}" alt="YouTube logo" loading="lazy"/>
</a>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <h5 class="widget-title wow fadeIn animated">About</h5>
                        <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                            <li><a href="{{ route('frontend.aboutUs') }}">About Us</a></li>
                            <li><a href="{{ route('frontend.contactUs') }}">Our Location</a></li>
                            <li><a href="{{ route('frontend.privacyPolicy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('frontend.termsConditions') }}">Terms &amp; Conditions</a></li>
                            <li><a href="{{ route('frontend.contactUs') }}">Contact Us</a></li>
                            <li>
                                <a href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20need%20assistance%20regarding%20my%20order,%20shipping,%20or%20product%20information.%20Please%20help%20me. "
                                    target="_blank">Support Center</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <h5 class="widget-title wow fadeIn animated">My Account</h5>
                        <ul class="footer-list wow fadeIn animated">
                            <li><a href="{{ route('login') }}">Sign In</a></li>
                            <li><a href="{{ route('frontend.cart') }}">View Cart</a></li>
                            <li><a href="{{ route('frontend.wishList') }}">My Wishlist</a></li>
                            <li><a href="{{ route('frontend.perchaseGuide') }}">Help</a></li>
                            <li><a href="{{ route('frontend.contactUs') }}">Our Outlets</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="widget-title wow fadeIn animated">How to order!</h5>
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <p class="wow fadeIn animated">
                                    Click on Below Button For Order Guide
                                </p>
                                <!-- <div class="download-app wow fadeIn animated">
                                    <a href="page-purchase-guide.html" class="hover-up mb-sm-4 mb-lg-0"><img
                                            class="active" src="frontend/assets/imgs/theme/PG.jpg" alt=""></a>
                                    <a href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20want%20to%20place%20an%20order.%20Please%20assist%20me."
                                        target="_blank" class="hover-up"><img src="frontend/assets/imgs/theme/WP.jpg" alt=""></a>
                                </div> -->
                                <div class="selec-btns" style="display: flex; gap: 10px; flex-wrap: wrap">
                                    <a class="select-lens" href="{{ route('frontend.perchaseGuide') }}">How to
                                        Order</a>
                                    <a class="select-lens" href="{{ route('frontend.blog') }}">Blog</a>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-12 mt-md-3 mt-lg-0">
                                <p class="mb-20 wow fadeIn animated">
                                    Secured Payment Gateways
                                </p>
                                <img class="wow fadeIn animated"
                                    src="{{ asset('frontend/assets/imgs/theme/payment-method.png') }}" alt="payment method" loading="lazy" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container pb-20 wow fadeIn animated">
            <div class="row">
                <div class="col-12 mb-20">
                    <div class="footer-bottom"></div>
                </div>
                <div class="col-lg-6">
                    <p class="float-md-left font-sm text-muted mb-0">
                        &copy; 2025,
                        <strong class="text-brand">Vision Plus Optical</strong> — Your
                        Trusted Eye Care Partner.
                    </p>
                </div>

                <div class="col-lg-6">
                    <p class="text-lg-end text-start font-sm text-muted mb-0">
                        Designed by
                        <a href="#"><strong class="text-brand">Ahsan Saeed:<small style="font-size:13px">03228717170</small></strong></a>. All rights reserved</p><br>
                </div>
            </div>
        </div>
    </footer>

    <!-- Elegant WhatsApp Floating Button -->
    <a href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20need%20assistance."
        class="whatsapp-float" target="_blank" aria-label="Chat on WhatsApp">
        <!-- WhatsApp Icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-whatsapp"
            viewBox="0 0 16 16">
            <path
                d="M13.601 2.326A7.875 7.875 0 0 0 8.005 0C3.582 0 .007 3.575 0 7.994a7.942 7.942 0 0 0 1.104 4.04L.058 16l4.124-1.08a7.973 7.973 0 0 0 3.823.974h.004c4.422 0 8.005-3.575 8.005-7.994a7.93 7.93 0 0 0-2.413-5.574ZM8.005 14.6a6.56 6.56 0 0 1-3.356-.923l-.24-.143-2.447.64.654-2.386-.156-.246a6.556 6.556 0 0 1 5.547-9.842h.003a6.559 6.559 0 0 1 6.548 6.548c0 3.623-2.956 6.552-6.553 6.552Zm3.666-4.967c-.2-.1-1.18-.582-1.364-.648-.183-.065-.317-.1-.45.1-.134.2-.516.648-.633.782-.116.134-.233.15-.433.05-.2-.1-.843-.31-1.604-.991-.593-.528-.993-1.177-1.11-1.376-.117-.2-.012-.3.088-.4.09-.09.2-.233.3-.35.1-.117.134-.2.2-.333.067-.134.034-.25-.017-.35-.05-.1-.45-1.084-.616-1.484-.162-.39-.327-.334-.45-.34l-.383-.006a.737.737 0 0 0-.533.25c-.183.2-.7.683-.7 1.667 0 .983.717 1.935.817 2.067.1.133 1.41 2.15 3.42 3.015.478.206.85.33 1.14.422.48.153.917.132 1.263.08.385-.057 1.18-.48 1.347-.944.167-.465.167-.865.117-.95-.05-.084-.183-.133-.383-.233Z" />
        </svg>
    </a>
    <!-- End Elegant WhatsApp Floating Button -->




    <script>
        $(document).ready(function () {
            // Remove item from cart in header
            $('.remove-from-cart-header').on('click', function (e) {
                e.preventDefault();
                const itemId = $(this).data('id');

                $.ajax({
                    url: '{{ route('frontend.removeCartItem') }}',
                    type: 'POST',
                    data: {
                        id: itemId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            // Reload the page to update cart
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
        });
    </script>
    <!-- Add these before your script -->

    <!-- Quick view functionality -->
    <script>
        $(document).ready(function () {
            $(document).on('click', '.quick-view-btn', function (e) {
                e.preventDefault();

                var productId = $(this).data('product-id');
                var url = $(this).attr('href');

                // Show loading spinner
                $('#quickViewModal .modal-body').html(
                    '<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );

                // Fetch product data via AJAX
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Update modal content
                            $('#quickViewModal .modal-body').html(response.html);

                            // Initialize product image slider
                            initQuickViewSlider();
                        }
                    },
                    error: function (xhr) {
                        $('#quickViewModal .modal-body').html(
                            '<div class="alert alert-danger">Error loading product details</div>'
                        );
                    }
                });
            });

            function initQuickViewSlider() {
                // Initialize your image slider here
                // This depends on what slider plugin you're using
                $('.product-image-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-nav-thumbnails'
                });

                $('.slider-nav-thumbnails').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    asNavFor: '.product-image-slider',
                    dots: false,
                    focusOnSelect: true
                });

                // Color selection functionality
                $('.color-button').on('click', function () {
                    var index = $(this).data('index');
                    $('.product-image-slider').slick('slickGoTo', index);
                    $('.color-button').removeClass('active');
                    $(this).addClass('active');
                });
            }
        });
    </script>

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
    <script>
            $(document).ready(function () {
            let searchTimeout;

            // Handle both desktop and mobile search inputs
            $('.search-style-2 #search-input, .mobile-search #search-input').on('input', function() {
                const query = $(this).val().trim();
                const form = $(this).closest('form');
                const dropdown = form.next('.search-results-dropdown');
                const category = form.find('select[name="category"]').val();

                clearTimeout(searchTimeout);

                if (!query) {
                    dropdown.hide();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    // Show loading state
                    dropdown.html(
                        '<div class="search-loading p-3 text-center">' +
                        '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>' +
                        ' Searching...</div>'
                    ).show();

                    $.ajax({
                        url: form.attr('action'),
                        method: 'GET',
                        data: {
                            query: query,
                            category: category,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                dropdown.html(response.html).show();
                            } else {
                                dropdown.html(
                                    '<div class="no-results-found p-4 text-center">' +
                                    '<i class="fas fa-search text-muted mb-2" style="font-size: 2rem;"></i>' +
                                    '<p class="text-muted mb-0">No products found</p></div>'
                                ).show();
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = 'Error performing search';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            dropdown.html(
                                '<div class="search-error p-3 text-center text-danger">' +
                                '<i class="fas fa-exclamation-circle me-2"></i>' + errorMessage + '</div>'
                            ).show();
                        }
                    });
                }, 300);
            });

            // Close dropdown when clicking outside (for both desktop and mobile)
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.search-style-2, .mobile-search').length) {
                    $('.search-results-dropdown').hide();
                }
            });

            // Handle category change (desktop only)
            $('.search-style-2 select[name="category"]').on('change', function () {
                const searchInput = $(this).closest('form').find('#search-input');
                if (searchInput.val().trim()) {
                    searchInput.trigger('input');
                }
            });

            // Keep dropdown open when clicking inside it (both versions)
            $('.search-results-dropdown').on('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>
    @stack('scripts')

    <!-- Search Functionality -->

    
    
  <!-- Vendor JS -->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery-ui.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}" defer ></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}" defer ></script>

    <!-- Template JS -->
    <script src="{{ asset('frontend/assets/js/main.js') }}?v=3.5" defer ></script>
    <script src="{{ asset('frontend/assets/js/shop.js') }}?v=3.5" defer ></script>
    <script src="{{ asset('frontend/assets/js/custom.js') }}?v=3.5" defer ></script>
    

</body>

</html>
