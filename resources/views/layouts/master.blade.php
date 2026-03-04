<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>POS System - @yield('title', 'Dashboard')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('user/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('user/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <small class="text-white mx-2">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</small>
                    @if(Auth::check())
                        <small class="text-white mx-2">|</small>
                        <small class="text-white mx-2">Role: {{ ucfirst(Auth::user()->role) }}</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="{{ Auth::check() ? (Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin' ? route('AdminHome') : route('userHome')) : route('login') }}" class="navbar-brand">
                    <h1 class="text-primary display-6">POS System</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        @auth
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin')
                                <!-- Admin Navigation -->
                                <a href="{{ route('AdminHome') }}" class="nav-item nav-link {{ request()->routeIs('AdminHome') ? 'active' : '' }}">Dashboard</a>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('category#*') ? 'active' : '' }}" data-bs-toggle="dropdown">Categories</a>
                                    <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                        <a href="{{ route('category#List') }}" class="dropdown-item">Category List</a>
                                    </div>
                                </div>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-bs-toggle="dropdown">Products</a>
                                    <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                        <a href="{{ route('admin.products.index') }}" class="dropdown-item">All Products</a>
                                        <a href="{{ route('admin.products.create') }}" class="dropdown-item">Add Product</a>
                                    </div>
                                </div>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-bs-toggle="dropdown">Orders</a>
                                    <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                        <a href="{{ route('admin.orders.index') }}" class="dropdown-item">Order Management</a>
                                    </div>
                                </div>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('profile#*') || request()->routeIs('change#*') ? 'active' : '' }}" data-bs-toggle="dropdown">Account</a>
                                    <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                        <a href="{{ route('profile#page') }}" class="dropdown-item">Profile</a>
                                        <a href="{{ route('change#pwd') }}" class="dropdown-item">Change Password</a>
                                    </div>
                                </div>
                            @else
                                <!-- User Navigation -->
                                <a href="{{ route('userHome') }}" class="nav-item nav-link {{ request()->routeIs('userHome') ? 'active' : '' }}">Home</a>
                                <a href="{{ route('user.products.index') }}" class="nav-item nav-link {{ request()->routeIs('user.products.*') ? 'active' : '' }}">Shop</a>
                                <a href="{{ route('user.cart.index') }}" class="nav-item nav-link {{ request()->routeIs('user.cart.*') ? 'active' : '' }}">Cart</a>
                                <a href="{{ route('user.orders.index') }}" class="nav-item nav-link {{ request()->routeIs('user.orders.*') ? 'active' : '' }}">Orders</a>
                            @endif
                        @endauth
                    </div>
                    <div class="d-flex m-3 me-0">
                        @auth
                            @if(Auth::user()->role == 'user')
                                <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="fas fa-search text-primary"></i>
                                </button>
                                <a href="{{ route('user.cart.index') }}" class="position-relative me-4 my-auto">
                                    <i class="fa fa-shopping-bag fa-2x"></i>
                                    <span id="cart-count" class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">0</span>
                                </a>
                            @endif
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle my-auto" data-bs-toggle="dropdown">
                                    <i class="fas fa-user fa-2x"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end m-0 bg-secondary rounded-0">
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin')
                                        <a href="{{ route('profile#page') }}" class="dropdown-item"><i class="fas fa-user me-2"></i>Profile</a>
                                        <a href="{{ route('change#pwd') }}" class="dropdown-item"><i class="fas fa-lock me-2"></i>Change Password</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Search Modal (for users only) -->
    @auth
        @if(Auth::user()->role == 'user')
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <form action="{{ route('user.products.index') }}" method="GET" class="input-group w-75 mx-auto d-flex">
                            <input type="search" name="search" class="form-control p-3" placeholder="Search products..." aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <!-- Main Content -->
    <div style="margin-top: 100px;">
        @yield('content')
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5);">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">POS System</h1>
                            <p class="text-secondary mb-0">Point of Sale Management</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email" placeholder="Your Email">
                            <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">About POS System</h4>
                        <p class="mb-4">A comprehensive Point of Sale system for managing products, orders, and inventory efficiently.</p>
                        <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Quick Links</h4>
                        @auth
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin')
                                <a class="btn-link" href="{{ route('AdminHome') }}">Dashboard</a>
                                <a class="btn-link" href="{{ route('admin.products.index') }}">Products</a>
                                <a class="btn-link" href="{{ route('admin.orders.index') }}">Orders</a>
                                <a class="btn-link" href="{{ route('category#List') }}">Categories</a>
                            @else
                                <a class="btn-link" href="{{ route('userHome') }}">Home</a>
                                <a class="btn-link" href="{{ route('user.products.index') }}">Shop</a>
                                <a class="btn-link" href="{{ route('user.cart.index') }}">Cart</a>
                                <a class="btn-link" href="{{ route('user.orders.index') }}">Orders</a>
                            @endif
                        @else
                            <a class="btn-link" href="{{ route('login') }}">Login</a>
                            <a class="btn-link" href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Account</h4>
                        @auth
                            <a class="btn-link" href="{{ Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin' ? route('profile#page') : '#' }}">My Account</a>
                            <a class="btn-link" href="{{ Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin' ? route('change#pwd') : '#' }}">Change Password</a>
                        @else
                            <a class="btn-link" href="{{ route('login') }}">Login</a>
                            <a class="btn-link" href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <p>Address: 123 Street, New York</p>
                        <p>Email: support@possystem.com</p>
                        <p>Phone: +0123 4567 8910</p>
                        <p>Payment Accepted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>POS System</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <span>© {{ date('Y') }} POS System. All rights reserved.</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('user/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('user/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('user/js/main.js') }}"></script>

    <!-- SweetAlert -->
    @include('sweetalert::alert')

    @stack('scripts')
</body>
</html>
