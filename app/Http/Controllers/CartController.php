<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem; // Убедитесь, что CartItem импортирован
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Получает или создает корзину для текущего пользователя/сессии.
     */
    private function getOrCreateCart()
    {
        $cart = null;

        if (Auth::check()) {
            // Если пользователь аутентифицирован, ищем корзину по user_id
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            // Если у пользователя была анонимная корзина по session_id,
            // можно объединить её здесь (логика ниже)
            if (session()->has('cart_session_id')) {
                $anonymousCart = Cart::where('session_id', session('cart_session_id'))->first();
                if ($anonymousCart && $anonymousCart->id !== $cart->id) {
                    // Объединяем товары из анонимной корзины в корзину пользователя
                    foreach ($anonymousCart->items as $item) {
                        $existingItem = $cart->items()->where('product_id', $item->product_id)->first();
                        if ($existingItem) {
                            $existingItem->quantity += $item->quantity;
                            $existingItem->save();
                        } else {
                            // Если товар не существует в корзине пользователя, переносим его
                            $item->cart_id = $cart->id; // Привязываем к корзине пользователя
                            $item->save();
                        }
                    }
                    $anonymousCart->delete(); // Удаляем анонимную корзину
                    session()->forget('cart_session_id');
                }
            }
        } else {
            // Если пользователь не аутентифицирован, ищем корзину по session_id
            $sessionId = session()->get('cart_session_id');
            if (!$sessionId) {
                $sessionId = Str::uuid(); // Генерируем новый уникальный ID сессии
                session()->put('cart_session_id', $sessionId);
            }
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart;
    }

    /**
     * Отображает содержимое корзины.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();

        // Загружаем товары вместе с позициями корзины
        $cartItems = $cart->items()->with('product')->get()->map(function ($item) {
            $product = $item->product;
            // Важно: проверьте, что $product не null (если продукт был удален, но остался в корзине)
            if (!$product) {
                return null; // Или обработайте это как-то иначе
            }
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image, // Основное изображение
                'quantity' => $item->quantity,
                'item_total' => $product->price * $item->quantity,
                'cart_item_id' => $item->id, // Идентификатор позиции в корзине для обновления/удаления
            ];
        })->filter()->values()->toArray(); // Удаляем null элементы и переиндексируем массив

        // Рассчитываем общую сумму
        $total = collect($cartItems)->sum('item_total');

        return Inertia::render('Cart', [ // Убедитесь, что 'Cart1' это правильное имя файла компонента
            'cartItems' => $cartItems,
            'cartTotal' => $total,
        ]);
    }

    /**
     * Добавляет товар в корзину.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function add(Request $request)
    {
        // Валидация входных данных
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = $this->getOrCreateCart(); // Получаем или создаем корзину для текущего пользователя/сессии

        // Ищем, есть ли уже этот товар в корзине
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Если товар уже есть, обновляем количество
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Если товара нет, создаем новую позицию в корзине
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        // После успешного добавления/обновления, перенаправляем на страницу корзины
        // Это заставит Inertia получить новые данные корзины через метод index()
        return Inertia::location(route('cart.index'));
    }


    /**
     * Обновляет количество товара в корзине.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id', // Используем cart_item_id
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItemId = $request->input('cart_item_id');
        $quantity = $request->input('quantity');

        $cart = $this->getOrCreateCart();

        // Ищем позицию корзины, принадлежащую текущей корзине
        $cartItem = $cart->items()->where('id', $cartItemId)->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            return back()->with('success', 'Количество товара обновлено!');
        }

        return back()->with('error', 'Товар не найден в корзине!');
    }

    /**
     * Удаляет товар из корзины.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id', // Используем cart_item_id
        ]);

        $cartItemId = $request->input('cart_item_id');

        $cart = $this->getOrCreateCart();

        // Ищем позицию корзины, принадлежащую текущей корзине
        $cartItem = $cart->items()->where('id', $cartItemId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'Товар удален из корзины!');
        }

        return back()->with('error', 'Товар не найден в корзине!');
    }
}