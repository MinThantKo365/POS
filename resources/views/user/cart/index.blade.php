@extends('layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Shopping Cart</h1>
        
        @if($carts->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $cart->product->image ? asset('storage/' . $cart->product->image) : asset('user/img/fruite-item-1.jpg') }}" 
                                                 alt="{{ $cart->product->name }}" 
                                                 class="img-thumbnail me-3" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                            <div>
                                                <h5 class="mb-0">{{ $cart->product->name }}</h5>
                                                <small class="text-muted">{{ $cart->product->category->name ?? 'Uncategorized' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($cart->product->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('user.cart.update', $cart) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="qty" value="{{ $cart->qty }}" min="1" max="{{ $cart->product->stock }}" class="form-control" style="width: 80px;" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td>${{ number_format($cart->product->price * $cart->qty, 2) }}</td>
                                    <td>
                                        <form action="{{ route('user.cart.destroy', $cart) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove from cart?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="mb-4">Order Summary</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span>Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total:</strong>
                            <strong>${{ number_format($total, 2) }}</strong>
                        </div>
                        <form action="{{ route('user.orders.store') }}" method="POST">
                            @csrf
                            @foreach($carts as $cart)
                                <input type="hidden" name="cart_ids[]" value="{{ $cart->id }}">
                            @endforeach
                            <button type="submit" class="btn btn-primary w-100">Proceed to Checkout</button>
                        </form>
                        <a href="{{ route('userHome') }}" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info text-center">
            <h4>Your cart is empty</h4>
            <p>Start shopping to add items to your cart!</p>
            <a href="{{ route('userHome') }}" class="btn btn-primary">Go Shopping</a>
        </div>
        @endif
    </div>
</div>
@endsection
