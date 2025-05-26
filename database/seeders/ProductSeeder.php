<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Курс по реакту',
                'description' => 'Полный курс по React.js',
                'price' => 800,
                'image' => 'kursreact.webp',
                'images' => json_encode(['kursreact.webp', 'kursreact2.webp']),
                'category' => 'kurs',
                'is_popular' => true
            ],
             [
                'name' => 'Курс по js',
                'description' => 'Полный курс по js',
                'price' => 500,
                'image' => 'kursjs.webp',
                'images' => json_encode(['kursjs.webp', 'kursjs2.webp']),
                'category' => 'kurs',
                'is_popular' => true
            ],
            [
                'name' => 'Шаблон свадебный',
                'description' => 'Полный курс по React.js',
                'price' => 80,
                'image' => 'svadba1.png',
                'images' => json_encode(['svadba1.png', 'svadba1.png']),
                'category' => 'shabl',
                'is_popular' => true
            ],
             [
                'name' => 'Книга Гарри Поттер',
                'description' => 'Полный курс по React.js',
                'price' => 480,
                'image' => 'garry.webp',
                'images' => json_encode(['garry.webp', 'garry2.webp']),
                'category' => 'books',
                'is_popular' => true
            ],
             [
                'name' => 'Книга Властелин Колец',
                'description' => 'Полный курс по React.js',
                'price' => 420,
                'image' => 'kolec.webp',
                'images' => json_encode(['kolec.webp', 'kolec2.webp']),
                'category' => 'books',
                'is_popular' => true
            ],
            [
                'name' => 'Шаблон приглашения',
                'description' => 'Полный курс по React.js',
                'price' => 220,
                'image' => 'dr1.webp',
                'images' => json_encode(['dr1.webp', 'dr2.webp']),
                'category' => 'shabl',
                'is_popular' => true
            ],
            [
                'name' => 'Шаблон презентации',
                'description' => 'Полный курс по React.js',
                'price' => 180,
                'image' => 'preza2.webp',
                'images' => json_encode(['preza2.webp', 'preza2.webp']),
                'category' => 'shabl',
                'is_popular' => true
            ],
            [
                'name' => 'Шаблон презентации',
                'description' => 'Полный курс по React.js',
                'price' => 180,
                'image' => 'preza3.webp',
                'images' => json_encode(['preza3.webp', 'preza3.webp']),
                'category' => 'shabl',
                'is_popular' => true
            ],
            [
                'name' => 'Шаблон презентации',
                'description' => 'Полный курс по React.js',
                'price' => 180,
                'image' => 'prezent.webp',
                'images' => json_encode(['prezent.webp', 'prezent.webp']),
                'category' => 'shabl',
                'is_popular' => true
            ],
            [
                'name' => 'Книга сталкер',
                'description' => 'Полный курс по React.js',
                'price' => 580,
                'image' => 'stalker.webp',
                'images' => json_encode(['stalker.webp', 'stalker2.webp']),
                'category' => 'books',
                'is_popular' => true
            ],
          
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}