<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'images', // Добавьте images в fillable
        'category',
    ];

    protected $casts = [
        'images' => 'array', // Автоматически преобразовывать JSON в массив и обратно
    ];
}