<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::all()->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ? '/storage/'.$product->image : null,
            ])
        ]);
    }

 // Показ формы создания
public function create()
{
    return Inertia::render('Admin/Products/Create');
}

// Сохранение товара
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category' => 'required|in:kurs,books,shabl',
        'image' => 'required|image|max:2048',
    ]);

    // Сохранение изображения
    $imagePath = $request->file('image')->store('products', 'public');
    $validated['image'] = $imagePath;

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Товар добавлен');
}

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:kurs,books,shabl',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            Storage::disk('public')->delete($product->image);
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->hasFile('images')) {
            // Удаляем старые дополнительные изображения
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            $imagesPaths = [];
            foreach ($request->file('images') as $image) {
                $imagesPaths[] = $image->store('products', 'public');
            }
            $validated['images'] = $imagesPaths;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product)
    {
        // Удаляем изображение
        Storage::disk('public')->delete($product->image);
        
        $product->delete();
        
        return redirect()->back()->with('success', 'Товар удален');
    }
}