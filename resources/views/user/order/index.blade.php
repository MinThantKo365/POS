@extends('layouts.master')
@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">My Orders</h1>
        
        @if($orders->count() > 0)
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order Code</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_code }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $order->product->image ? asset('storage/' . $order->product->image) : asset('user/img/fruite-item-1.jpg') }}" 
                                             alt="{{ $order->product->name }}" 
                                             class="img-thumbnail me-2" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                        <span>{{ $order->product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $order->count }}</td>
                                <td>${{ number_format($order->total_price ?? ($order->product->price * $order->count), 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'completed') bg-success
                                        @elseif($order->status == 'processing') bg-primary
                                        @elseif($order->status == 'cancelled') bg-danger
                                        @else bg-warning
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    @if($order->status != 'completed' && $order->status != 'cancelled')
                                    <form action="{{ route('user.orders.cancel', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this order?')">Cancel</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info text-center">
            <h4>No orders yet</h4>
            <p>Start shopping to place your first order!</p>
            <a href="{{ route('userHome') }}" class="btn btn-primary">Go Shopping</a>
        </div>
        @endif
    </div>
</div>
@endsection
