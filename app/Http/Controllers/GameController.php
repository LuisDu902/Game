<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function search(Request $request){
        $order = $request->input('order', 'name');
        $filter = $request->input('filter', 0);
        $search = $request->input('search', '');

        $query = Game::where(function ($query) use ($search) {
            $query->where('name', 'ilike', "%$search%");
        });

        if ($filter != 0) {
            $query->where('game_category_id', $filter);
        }

        $games = $query->orderBy($order)->paginate(10);

        return view('partials._gamesTable', compact('games'))->render();
    }

    public function create($category_id)
    {
        $this->authorize('create', Game::class);
        $category = GameCategory::find($category_id);
        return view('pages.newGame', ['category' => $category]);
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

    public function store(Request $request)
    {
        $this->authorize('create', Game::class);

        $request->validate([
            'name' => 'required|max:256|unique:game',
            'description' => 'required'
        ]);
        
        $game = Game::create([
            'name' => $request->input('name'),
            'description' => trim($request->input('description')),
            'nr_members' => 0,
            'game_category_id' => $request->category_id
        ]);

        return response()->json(['id' => $game->id]);
    }


    public function delete(Request $request, $id) {

        $this->authorize('delete', Game::class);

        $game = Game::findOrFail($id);
       
        $game->delete();

        return response()->json(['id' => $game->id ]); 
    }

    public function edit($id){
        $this->authorize('edit', Game::class);
        $game = Game::findOrFail($id);
        return view('pages.editGame', ['game' => $game]);
    }

    public function update(Request $request, $id) {
        $this->authorize('edit', Game::class);

        $request->validate([
            'name' => 'required|max:256',
            'description' => 'required'
        ]);
        
        $game = Game::findOrFail($id);

        $game->name = $request->name;
        $game->description = $request->description;

        $game->save();

        return response()->json(['id' => $game->id ]); 
    }

}
