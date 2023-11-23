<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('pages.newQuestion', compact('games'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        $questions = $game->questions()->paginate(5);
        return view('pages.game', ['game' => $game, 'questions' => $questions]);
    }


}
