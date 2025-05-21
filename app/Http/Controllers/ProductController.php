<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function showProducts()
    {
        $products = Product::where('stock', '>', 10)->get();
        return view('products', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);

        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + $request->quantity
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Added to cart.');
    }
}
