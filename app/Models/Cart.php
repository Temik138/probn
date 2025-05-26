<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id', // Если вы используете анонимные корзины
    ];

    /**
     * Корзина принадлежит одному пользователю.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Корзина содержит много позиций (товаров).
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}