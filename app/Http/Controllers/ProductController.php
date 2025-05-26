<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia; 

class ProductController extends Controller
{
    public function index()
    {
        // Здесь можно изменить map, если нужно, чтобы image_url был полный путь
        // Но для `/images/${product.image}` в Vue достаточно только имени файла.
        return Inertia::render('Catalog', [
            'products' => Product::all()->map(function ($product) {
                // Преобразуем images из JSON строки в массив, если это строка
                $images_array = is_string($product->images)
                    ? json_decode($product->images, true)
                    : ($product->images ?? []); // Если уже массив или null

                // Если images пуст, но есть основное изображение, добавляем его в галерею
                if (empty($images_array) && $product->image) {
                    $images_array = [$product->image];
                }
                
                // Возвращаем все необходимые поля, включая image (основное) и images (галерея)
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image, // Основное изображение для карточки каталога
                    'images' => $images_array, // Массив изображений для галереи на странице продукта
                    'category' => $product->category, // Для фильтрации
                ];
            })->toArray()
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $images_array = [];
        if (is_string($product->images)) {
            $decoded_images = json_decode($product->images, true);
            $images_array = is_array($decoded_images) ? $decoded_images : [];
        } elseif (is_array($product->images)) {
            $images_array = $product->images;
        }

        // Убедимся, что основное изображение всегда в начале списка, если оно есть и не повторяется
        if (!empty($product->image) && !in_array($product->image, $images_array)) {
            array_unshift($images_array, $product->image);
        } elseif (empty($images_array) && !empty($product->image)) {
            $images_array = [$product->image];
        }


        $product_for_vue = [
            'id'          => $product->id,
            'name'        => $product->name,
            'description' => $product->description,
            'price'       => $product->price,
            'image'       => $product->image,  // Основное изображение
            'images'      => array_values(array_unique($images_array)), // Убираем дубликаты и переиндексируем
        ];

        return Inertia::render('Product', [
            'productData' => $product_for_vue
        ]);
    }

    // МЕТОД для главной страницы
    public function home()
    {
        $displayProducts = Product::orderBy('id', 'asc')->take(3)->get()->map(function ($product) {
            return [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price, 
                'image' => $product->image,
            ];
        })->toArray();

        return Inertia::render('Home', [
            'featuredProducts' => $displayProducts
        ]);
    }
}