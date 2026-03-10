<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Показать корзину
     */
    public function cart()
    {
        $user = Auth::user();
        
        // Получаем все товары из корзины текущего пользователя
        $cartItems = CartItem::where('user_id', $user->id)
            ->with('game')
            ->get();

        // Считаем общую сумму
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return view('orders.cart', compact('cartItems', 'total'));
    }

    /**
     * Добавить игру в корзину
     */
    public function addToCart(Game $game)
    {
        $user = Auth::user();

        // Проверяем, есть ли уже такая игра в корзине
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('game_id', $game->id)
            ->first();

        if ($cartItem) {
            // Если есть - увеличиваем количество
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Если нет - создаем новую запись
            CartItem::create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'quantity' => 1,
                'price' => $game->price
            ]);
        }

        return redirect()->route('orders.cart')->with('success', 'Игра добавлена в корзину!');
    }

    /**
     * Удалить игру из корзины
     */
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        // Проверяем, что это корзина текущего пользователя
        if ($cartItem->user_id != Auth::id()) {
            abort(403, 'Доступ запрещен');
        }
        
        $cartItem->delete();

        return redirect()->route('orders.cart')->with('success', 'Игра удалена из корзины.');
    }

    /**
     * Страница имитации оплаты
     */
    public function payment()
    {
        $user = Auth::user();
        
        $cartItems = CartItem::where('user_id', $user->id)
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('orders.cart')->with('error', 'Корзина пуста');
        }

        return view('orders.payment', compact('cartItems'));
    }

    /**
     * Оформление заказа (имитация оплаты)
     */
    public function checkout(Request $request)
    {
        // Используем транзакцию для безопасности
        return DB::transaction(function() use ($request) {
            $user = Auth::user();
            
            // Получаем товары из корзины
            $cartItems = CartItem::where('user_id', $user->id)
                ->with('game')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('orders.cart')->with('error', 'Ваша корзина пуста.');
            }

            // Считаем общую сумму
            $total = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });

            // Создаем заказ
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total
            ]);

            // Переносим товары из корзины в заказ
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $item->game_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);
                
                // Удаляем товар из корзины
                $item->delete();
            }

            return redirect()->route('orders.history')
                ->with('success', 'Заказ успешно оформлен! Спасибо за покупку (имитация оплаты).');
        });
    }

    /**
     * История заказов пользователя
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.game')  // Загружаем игры для каждого товара
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.history', compact('orders'));
    }
}