<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::withCount('reviews')->latest()->paginate(15);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:100',
            'release_date' => 'required|date',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        Game::create($request->all());

        return redirect()->route('admin.games.index')
            ->with('success', 'Игра добавлена');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:100',
            'release_date' => 'required|date',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        $game->update($request->all());

        return redirect()->route('admin.games.index')
            ->with('success', 'Игра обновлена');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Игра удалена');
    }
}