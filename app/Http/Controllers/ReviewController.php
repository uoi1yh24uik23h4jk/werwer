<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Game $game)
    {
        $user = Auth::user();

        // Проверка, купил ли пользователь игру
        $purchased = $user->orders()
            ->whereHas('items', function($q) use ($game) {
                $q->where('game_id', $game->id);
            })
            ->exists();

        if (!$purchased) {
            return redirect()->back()->with('error', 'Вы можете оставить отзыв только на купленные игры.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен.');
    }
}