@extends('layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary">← Back to Orders</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Order Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Order Code:</strong> {{ $order->order_code }}
                            </div>
                            <div class="col-md-6">
                                <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ $order->product->image ? asset('storage/' . $order->product->image) : asset('user/img/fruite-item-1.jpg') }}" 
                                 alt="{{ $order->product->name }}" 
                                 class="img-thumbnail me-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <div>
                                <h4>{{ $order->product->name }}</h4>
                                <p class="text-muted mb-2">{{ $order->product->category->name ?? 'Uncategorized' }}</p>
                                <p class="mb-0"><strong>Quantity:</strong> {{ $order->count }}</p>
                                <p class="mb-0"><strong>Price:</strong> ${{ number_format($order->product->price, 2) }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Order Summary</h5>
                                <p><strong>Subtotal:</strong> ${{ number_format($order->product->price * $order->count, 2) }}</p>
                                <p><strong>Shipping:</strong> Free</p>
                                <hr>
                                <h5><strong>Total:</strong> ${{ number_format($order->total_price ?? ($order->product->price * $order->count), 2) }}</h5>
                            </div>
                            <div class="col-md-6">
                                <h5>Status</h5>
                                <span class="badge 
                                    @if($order->status == 'completed') bg-success
                                    @elseif($order->status == 'processing') bg-primary
                                    @elseif($order->status == 'cancelled') bg-danger
                                    @else bg-warning
                                    @endif fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
