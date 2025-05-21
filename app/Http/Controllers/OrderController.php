<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ✅ NEW: Show Order Confirmation Page
    public function confirm(Request $request)
    {
        $user = $request->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        return view('order.confirm', compact('cartItems'));
    }

    // ✅ Place Order
    public function place(Request $request)
    {
        $user = $request->user();

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $cartItems->sum(function ($item) {
                    return $item->totalPrice(); // calls the method you defined
                }),
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // return redirect()->back()->with('error', 'Failed to place order. Please try again.');
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    // ✅ Order Success Page
    public function success()
    {
        return view('order.success');
    }
}
