<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display user's order history.
     */
    public function index()
    {
        $orders = order::where('user_id', Auth::id())
            ->with('product.category')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.order.index', compact('orders'));
    }

    /**
     * Store a new order from cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'exists:carts,id',
        ]);

        $carts = cart::whereIn('id', $request->cart_ids)
            ->where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($carts->isEmpty()) {
            Alert::error('Error', 'No items selected!');
            return back();
        }

        $orderCode = 'ORD-' . strtoupper(Str::random(8));

        foreach ($carts as $cartItem) {
            // Check stock
            if ($cartItem->product->stock < $cartItem->qty) {
                Alert::error('Out of Stock', $cartItem->product->name . ' is out of stock!');
                return back();
            }

            $totalPrice = $cartItem->product->price * $cartItem->qty;

            order::create([
                'user_id' => Auth::id(),
                'product_id' => $cartItem->product_id,
                'count' => $cartItem->qty,
                'status' => 'pending',
                'order_code' => $orderCode,
                'total_price' => $totalPrice,
            ]);

            // Update product stock
            $cartItem->product->decrement('stock', $cartItem->qty);

            // Remove from cart
            $cartItem->delete();
        }

        Alert::success('Order Placed', 'Your order has been placed successfully! Order Code: ' . $orderCode);
        return redirect()->route('user.orders.index');
    }

    /**
     * Display order details.
     */
    public function show(order $order)
    {
        // Check if order belongs to user or user is admin
        if (!Auth::check()) {
            abort(403);
        }
        
        if ($order->user_id != Auth::id() && Auth::user()->role != 'admin' && Auth::user()->role != 'superAdmin') {
            abort(403);
        }

        $order->load('product.category', 'user');

        return view('user.order.show', compact('order'));
    }

    /**
     * Admin: Display all orders.
     */
    public function adminIndex()
    {
        $orders = order::with('product.category', 'user')
            ->orderByDesc('created_at')
            ->paginate(15);

        $stats = [
            'total' => order::count(),
            'pending' => order::where('status', 'pending')->count(),
            'processing' => order::where('status', 'processing')->count(),
            'completed' => order::where('status', 'completed')->count(),
            'cancelled' => order::where('status', 'cancelled')->count(),
        ];

        return view('admin.order.index', compact('orders', 'stats'));
    }

    /**
     * Admin: Update order status.
     */
    public function updateStatus(Request $request, order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // If order is cancelled and was not cancelled before, restore stock
        if ($request->status == 'cancelled' && $oldStatus != 'cancelled') {
            $order->product->increment('stock', $order->count);
        }

        // If order was cancelled and now being processed, reduce stock again
        if ($oldStatus == 'cancelled' && $request->status != 'cancelled') {
            if ($order->product->stock < $order->count) {
                Alert::error('Error', 'Not enough stock available!');
                $order->update(['status' => 'cancelled']);
                return back();
            }
            $order->product->decrement('stock', $order->count);
        }

        Alert::success('Status Updated', 'Order status updated successfully!');
        return back();
    }

    /**
     * User: Cancel own order.
     */
    public function cancel(order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        if ($order->status == 'completed') {
            Alert::error('Error', 'Cannot cancel completed order!');
            return back();
        }

        if ($order->status != 'cancelled') {
            $order->product->increment('stock', $order->count);
        }

        $order->update(['status' => 'cancelled']);
        Alert::success('Order Cancelled', 'Your order has been cancelled!');

        return back();
    }
}
