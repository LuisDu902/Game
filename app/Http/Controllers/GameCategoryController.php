<?php

namespace App\Http\Controllers;

use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = GameCategory::paginate(10);
        return view('pages.categories', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gameCategory = GameCategory::findOrFail($id);
        return view('pages.category', ['category' => $gameCategory]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameCategory $gameCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GameCategory $gameCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameCategory $gameCategory)
    {
        //
    }
}
