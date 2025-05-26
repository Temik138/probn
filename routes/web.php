<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Inertia\Inertia;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

// Маршруты для корзины - доступны всем
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->middleware('auth')->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Маршруты, требующие аутентификации
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home'); 
    })->name('dashboard');
    // Пример: Страница профиля (из Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->name('admin.products.index');
});

// Маршруты аутентификации, генерируемые Breeze
require __DIR__.'/auth.php';