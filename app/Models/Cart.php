<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    
    
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function totalPrice()
    {
        return $this->qty * $this->product->price;
    }
    
    public static function grandTotal($customerId)
    {
        $cartItems = Cart::where('user_id', $customerId)->get();
        $total = $cartItems->sum(function ($item) {
            return $item->totalPrice();
        });

        return $total;
    }
}
