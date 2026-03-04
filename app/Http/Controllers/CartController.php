<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index()
    {
        $carts = cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();
        
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->product->price * $cart->qty;
        }

        return view('user.cart.index', compact('carts', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is in stock
        if ($product->stock < $request->qty) {
            Alert::error('Out of Stock', 'Not enough stock available!');
            return back();
        }

        // Check if product already in cart
        $existingCart = cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            $newQty = $existingCart->qty + $request->qty;
            if ($product->stock < $newQty) {
                Alert::error('Out of Stock', 'Not enough stock available!');
                return back();
            }
            $existingCart->update(['qty' => $newQty]);
            Alert::success('Cart Updated', 'Product quantity updated in cart!');
        } else {
            cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'qty' => $request->qty,
            ]);
            Alert::success('Added to Cart', 'Product added to cart successfully!');
        }

        return back();
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, cart $cart)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        // Check if cart belongs to user
        if ($cart->user_id != Auth::id()) {
            abort(403);
        }

        // Check stock
        if ($cart->product->stock < $request->qty) {
            Alert::error('Out of Stock', 'Not enough stock available!');
            return back();
        }

        $cart->update(['qty' => $request->qty]);
        Alert::success('Cart Updated', 'Cart updated successfully!');

        return back();
    }

    /**
     * Remove a product from the cart.
     */
    public function destroy(cart $cart)
    {
        // Check if cart belongs to user
        if ($cart->user_id != Auth::id()) {
            abort(403);
        }

        $cart->delete();
        Alert::success('Removed', 'Product removed from cart!');

        return back();
    }

    /**
     * Get cart count for navbar.
     */
    public function count()
    {
        $count = cart::where('user_id', Auth::id())->sum('qty');
        return response()->json(['count' => $count]);
    }
}
