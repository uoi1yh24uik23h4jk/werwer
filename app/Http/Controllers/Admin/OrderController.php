<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
                abort(403, 'Доступ запрещен');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Order::with('user', 'items.game');
        
        // Фильтр по пользователю
        if ($request->filled('user')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }
        
        // Фильтр по сумме
        if ($request->filled('min_price')) {
            $query->where('total', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('total', '<=', $request->max_price);
        }
        
        // Фильтр по дате
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $orders = $query->latest()->paginate(15);
        
        // Заказы за сегодня
        $ordersToday = Order::whereDate('created_at', today())->count();
        
        return view('admin.orders.index', compact('orders', 'ordersToday'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.game');
        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        // Удаляем связанные записи
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Заказ #' . $order->id . ' успешно удален');
    }
}