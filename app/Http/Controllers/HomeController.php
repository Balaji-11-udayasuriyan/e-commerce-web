<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;

use Illuminate\Support\Facades\Auth; // make sure to import Auth


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        $data = [
            "orders" => Order::where('user_id', $user->id)->get(),
            "products" => Product::where('stock', '>', 10)->get()
        ];

        return view("home", $data);
    }
}
