<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>vision-plus-optical-dashboard</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/assets/imgs/theme/vp_favicon.png')}}">

    <!-- Template CSS -->
    <link href="{{ asset('backend/assets/css/main.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ route('admin.dashboard') }}" class="brand-wrap">
                <img src="/backend/assets/imgs/theme/logo.svg" class="logo" alt="Evara Dashboard">
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.sliders') }}">
                        <i class="icon material-icons md-slideshow"></i>
                        <span class="text">Sliders</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.categories') }}">
                        <i class="icon material-icons md-category"></i>
                        <span class="text">Categories</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.products') }}">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Products</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.customersData*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.customersData') }}">
                        <i class="icon material-icons md-person"></i>
                        <span class="text">Customers</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.orders') }}">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Orders</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.reviews') }}">
                        <i class="icon material-icons md-comment"></i>
                        <span class="text">Reviews</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.payments.index') }}">
                        <i class="icon material-icons md-payment"></i>
                        <span class="text">Payments</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.popups*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.popups') }}">
                        <i class="icon material-icons md-filter_none"></i>
                        <span class="text">Popups</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.blog*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.blog.index') }}">
                        <i class="icon material-icons md-book"></i>
                        <span class="text">Blogs</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.contactList*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.contactList') }}">
                        <i class="icon material-icons md-mail_outline"></i>
                        <span class="text">Contact List</span>
                    </a>
                </li>
            </ul>
            <br>
            <br>
        </nav>
    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input list="search_terms" type="text" class="form-control" placeholder="Search term">
                        <button class="btn btn-light bg" type="button"> <i
                                class="material-icons md-search"></i></button>
                    </div>
                    <datalist id="search_terms">
                        <option value="Products">
                        <option value="New orders">
                        <option value="Apple iphone">
                        <option value="Ahmed Hassan">
                    </datalist>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i
                        class="material-icons md-apps"></i> </button>
                <ul class="nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link btn-icon" href="#">
                            <i class="material-icons md-notifications animation-shake"></i>
                            <span class="badge rounded-pill">3</span>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i
                                class="material-icons md-cast"></i></a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownLanguage"
                            aria-expanded="false"><i class="material-icons md-public"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            <a class="dropdown-item text-brand" href="#"><img
                                    src="/backend/assets/imgs/theme/flag-us.png" alt="English">English</a>
                            <a class="dropdown-item" href="#"><img src="/backend/assets/imgs/theme/flag-fr.png"
                                    alt="Français">Français</a>
                            <a class="dropdown-item" href="#"><img src="/backend/assets/imgs/theme/flag-jp.png"
                                    alt="Français">日本語</a>
                            <a class="dropdown-item" href="#"><img src="/backend/assets/imgs/theme/flag-cn.png"
                                    alt="Français">中国人</a>
                        </div>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                            aria-expanded="false"> <img class="img-xs rounded-circle"
                                src="/backend/assets/imgs/people/avatar2.jpg" alt="User"></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                    class="material-icons md-exit_to_app"></i>Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <section class="content-main">
            @yield('content')

        </section> <!-- content-main end// -->
        <footer class="main-footer font-xs">
            <div class="row pb-30 pt-15">
                <div class="col-sm-6">
                    <script>
                    </script> ©, vision plus optical.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end">
                        All rights reserved
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <script src="{{ asset('backend/assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/chart.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('backend/assets/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/assets/js/custom-chart.js') }}" type="text/javascript"></script>
    @stack('scripts')
</body>

</html>