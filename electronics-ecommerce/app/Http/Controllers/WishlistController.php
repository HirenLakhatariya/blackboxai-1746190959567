<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display the wishlist items.
     */
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        return view('wishlist.index', compact('wishlist'));
    }

    /**
     * Add a product to the wishlist.
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $wishlist = session()->get('wishlist', []);

        if (!in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Product added to wishlist!');
        }

        return redirect()->back()->with('info', 'Product already in wishlist!');
    }

    /**
     * Remove a product from the wishlist.
     */
    public function remove(Request $request, $productId)
    {
        $wishlist = session()->get('wishlist', []);
        if (($key = array_search($productId, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Product removed from wishlist!');
        }
        return redirect()->back()->with('error', 'Product not found in wishlist!');
    }
}
