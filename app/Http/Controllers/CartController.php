<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;


class CartController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $user_id = $user->id;

        // dump($user->id);

        // Retrieve the product and user information from the JSON request body             
        // $carts = Cart::all();
        $carts = Cart::with('product')->where('user_id', $user_id)->get();
        
        // dd($carts);

        // Transform the data to include the full URL for the image_path
        $transformedCarts = $carts->map(function ($row) {
            return [
                'id' => $row->id,
                'product_id' => $row->product->id,
                'name' => $row->product->name,
                'quantity' => (int) $row->quantity, // ✅ fixed key
                'price' => $row->product->price,
                // 'image_path' => $row->product->getImagePath(),                
            ];
        });

        // dd($transformedCarts);

        // Replace $customUserId with the actual user ID
        $grandTotal = Cart::grandTotal($user_id);
        
        $data = [
            'carts' => $transformedCarts, 
            'grand_total' => $grandTotal
        ];
        
        return view('cart', $data);
    }

    public function addToCart(Request $request)
    {
        $user = $request->user();

        $user_id = $user->id;

        // Retrieve the product and user information from the JSON request body
        $product_id = $request->input('product_id'); // or simply $request->product_id;


        // Retrieve the product and user information
        $product = Product::find($product_id);        
        // dump($requestData);

        // Check if the item is already in the cart
        $existingCartItem = Cart::where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->first();
        

        if ($existingCartItem) {
            // If the item is already in the cart, update the quantity
            $existingCartItem->quantity += 1;
            $existingCartItem->save();
            return redirect()->back()->with('success', $product->name . ' quantity updated in your cart.');
        } else {
            // If the item is not in the cart, create a new cart entry
            Cart::create([
                'product_id' => $product_id,
                'user_id' => $user->id,
                'quantity' => 1,
            ]);
            return redirect()->back()->with('success', $product->name . ' added to your cart.');
       }
    }

    public function removeFromCart(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Retrieve the product and user information from the JSON request body
        $cartItemId = $request->input('cart_id');

        // Retrieve the cart item
        $cartItem = Cart::find($cartItemId);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json(["error" => "Cart item not found."], 404);
        }

        // Check if the cart item belongs to the logged-in user
        if ($cartItem->user_id != $user->id) {
            return response()->json(["error" => "You are not authorized to remove this item from the cart."], 403);
        }

        // Remove the cart item
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from your cart.');
    }

    public function increaseQuantity(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Retrieve the product and user information from the JSON request body
        $cartItemId = $request->input('cart_id');
        
        // dd($cartItemId);
        // Retrieve the cart item
        $cartItem = Cart::find($cartItemId);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json(["error" => "Cart item not found."], 404);
        }

        // Check if the cart item belongs to the logged-in user
        if ($cartItem->user_id != $user->id) {
            return response()->json(["error" => "You are not authorized to update the quantity of this item in the cart."], 403);
        }

        // Increase the quantity
        $cartItem->quantity += 1;
        $cartItem->save();

        return redirect()->back()->with('success', 'Quantity increased in your cart.');
    }


    public function decreaseQuantity(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // dd($user);

        // Retrieve the product and user information from the JSON request body
        $cartItemId = $request->input('cart_id');
        
        // Retrieve the cart item
        $cartItem = Cart::find($cartItemId);

        // Check if the cart item exists
        if (!$cartItem) {
            return redirect()->back()->with('success', "Cart item not found.");
        }

        // Check if the cart item belongs to the logged-in user
        if ($cartItem->user_id != $user->id) {
            return redirect()->back()->with("success", "You are not authorized to update the quantity of this item in the cart.");
        }

        // Decrease the quantity, but ensure it doesn't go below 1
        $cartItem->quantity = max($cartItem->quantity - 1, 1);
        $cartItem->save();

        return redirect()->back()->with('success', 'Quantity decreased in your cart.');
    }

    public function clearCart(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        $user_id = $user->id;

        // Retrieve the cart items for the user
        $cartItems = Cart::where('user_id', $user_id)->get();

        // Check if any cart items were found
        if ($cartItems->isEmpty()) {
            return response()->json(["error" => "No items found in the cart for the logged-in user."], 404);
        }

        // Check if the cart items belong to the logged-in user
        foreach ($cartItems as $cartItem) {
            if ($cartItem->user_id != $user_id) {
                return response()->json(["error" => "You are not authorized to clear the cart. Cart items don't belong to the logged-in user."], 403);
            }
        }

        // Find and delete all cart items for the user
        Cart::where('user_id', $user_id)->delete();

        return response()->json(["message" => "Cart cleared successfully."], 200);
    }

}