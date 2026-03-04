@extends('layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-lg-4">
                <h1>Our Products</h1>
            </div>
            <div class="col-lg-8">
                <form action="{{ route('user.products.index') }}" method="GET" class="d-flex gap-2">
                    <select name="category" class="form-select" style="max-width: 200px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}" style="max-width: 250px;">
                    <select name="sort" class="form-select" style="max-width: 150px;">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('user.products.index') }}" class="btn btn-secondary">Clear</a>
                </form>
            </div>
        </div>
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('user/img/fruite-item-1.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary mb-2">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-primary mb-0">${{ number_format($product->price, 2) }}</h5>
                            <a href="{{ route('user.products.show', $product) }}" class="btn btn-primary btn-sm">View</a>
                        </div>
                        <small class="text-muted">Stock: {{ $product->stock }}</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>No products found</h4>
                    <p>Try adjusting your search or filter criteria.</p>
                </div>
            </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
