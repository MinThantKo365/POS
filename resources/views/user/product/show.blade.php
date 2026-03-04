@extends('layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('user/img/fruite-item-1.jpg') }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded">
            </div>
            <div class="col-lg-6">
                <h1 class="mb-3">{{ $product->name }}</h1>
                <div class="mb-3">
                    <span class="badge bg-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>
                <h3 class="text-primary mb-4">${{ number_format($product->price, 2) }}</h3>
                <p class="mb-4">{{ $product->description }}</p>
                <div class="mb-4">
                    <strong>Stock:</strong> 
                    @if($product->stock > 0)
                        <span class="text-success">{{ $product->stock }} available</span>
                    @else
                        <span class="text-danger">Out of Stock</span>
                    @endif
                </div>
                @if($product->stock > 0)
                <form action="{{ route('user.cart.store') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity:</label>
                        <input type="number" name="qty" id="qty" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa fa-shopping-bag me-2"></i> Add to Cart
                    </button>
                </form>
                @else
                <div class="alert alert-warning">
                    This product is currently out of stock.
                </div>
                @endif
                <a href="{{ route('user.products.index') }}" class="btn btn-outline-secondary">Back to Products</a>
            </div>
        </div>
        
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Related Products</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('user/img/fruite-item-1.jpg') }}" 
                                 alt="{{ $related->name }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $related->name }}</h5>
                                <p class="card-text">${{ number_format($related->price, 2) }}</p>
                                <a href="{{ route('user.products.show', $related) }}" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
