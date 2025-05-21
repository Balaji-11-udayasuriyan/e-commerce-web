<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($orderItem) {
            $product = $orderItem->product;

            if ($product->stock < $orderItem->quantity) {
                throw new \Exception("Insufficient stock for product: {$product->name}");
            }

            $product->decrement('stock', $orderItem->quantity);
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
