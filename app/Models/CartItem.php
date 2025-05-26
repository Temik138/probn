<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    /**
     * Позиция корзины принадлежит одной корзине.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Позиция корзины относится к одному продукту.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}