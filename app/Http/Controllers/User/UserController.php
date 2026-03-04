<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display user home page with products.
     */
    public function userHome(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->orderByDesc('created_at')->paginate(12);
        $categories = category::orderBy('name')->get();

        return view('user.home.list', compact('products', 'categories'));
    }
}
