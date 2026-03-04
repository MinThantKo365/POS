@extends('admin.layouts.master')
@section('content')
@php
    use App\Models\Product;
    use App\Models\order;
    use App\Models\category;
    use App\Models\cart;
    
    $totalProducts = Product::count();
    $totalOrders = order::count();
    $totalCategories = category::count();
    $pendingOrders = order::where('status', 'pending')->count();
    $totalRevenue = order::where('status', 'completed')->sum('total_price') ?? 0;
    $totalUsers = \App\Models\User::where('role', 'user')->count();
@endphp

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
    </div>
    <p class="mb-4">Welcome back, {{ Auth::user()->name }}!</p>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Products Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-primary border-4 shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-primary fw-bold small mb-1">Total Products</div>
                                <div class="h3 mb-0 fw-bold text-dark">{{ $totalProducts }}</div>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-box fa-3x text-primary opacity-25"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-primary small">
                                View Products <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-success border-4 shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-success fw-bold small mb-1">Total Orders</div>
                                <div class="h3 mb-0 fw-bold text-dark">{{ $totalOrders }}</div>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-shopping-cart fa-3x text-success opacity-25"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-success small">
                                View Orders <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-warning border-4 shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-warning fw-bold small mb-1">Pending Orders</div>
                                <div class="h3 mb-0 fw-bold text-dark">{{ $pendingOrders }}</div>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-clock fa-3x text-warning opacity-25"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.orders.index') }}?status=pending" class="text-decoration-none text-warning small">
                                View Pending <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-info border-4 shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-info fw-bold small mb-1">Total Revenue</div>
                                <div class="h3 mb-0 fw-bold text-dark">${{ number_format($totalRevenue, 2) }}</div>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-dollar-sign fa-3x text-info opacity-25"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted small">Completed orders</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row -->
        <div class="row g-4 mb-4">
            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-3x text-secondary mb-3"></i>
                        <h3 class="fw-bold">{{ $totalCategories }}</h3>
                        <p class="text-muted mb-0">Categories</p>
                        <a href="{{ route('category#List') }}" class="btn btn-sm btn-outline-primary mt-2">
                            Manage <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-secondary mb-3"></i>
                        <h3 class="fw-bold">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>

            <!-- Completed Orders Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h3 class="fw-bold">{{ order::where('status', 'completed')->count() }}</h3>
                        <p class="text-muted mb-0">Completed Orders</p>
                    </div>
                </div>
            </div>

            <!-- Low Stock Products Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h3 class="fw-bold">{{ Product::where('stock', '<', 10)->count() }}</h3>
                        <p class="text-muted mb-0">Low Stock Products</p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-danger mt-2">
                            Check <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-plus me-2"></i>Add Product
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('category#List') }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-tag me-2"></i>Manage Categories
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>View Orders
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('profile#page') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-user me-2"></i>My Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
