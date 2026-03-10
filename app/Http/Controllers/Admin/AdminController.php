<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users_count' => User::count(),
            'games_count' => Game::count(),
            'orders_count' => Order::count(),
            'reviews_count' => Review::count(),
            'total_revenue' => Order::sum('total'),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}