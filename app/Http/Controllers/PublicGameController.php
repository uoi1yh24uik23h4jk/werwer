<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class PublicGameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $games = $query->paginate(12);
        $genres = Game::select('genre')->distinct()->pluck('genre');

        return view('games.index', compact('games', 'genres'));
    }

    public function show(Game $game)
    {
        $reviews = $game->reviews()->latest()->get();
        return view('games.show', compact('game', 'reviews'));
    }
}