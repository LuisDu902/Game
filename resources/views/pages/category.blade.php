@extends('layouts.app')

@section('content')
    <x-sidebar></x-sidebar>

    <div class="headers">
        <button class="open-sidebar white">
            <ion-icon name="menu"></ion-icon>
        </button>
        <ul class="breadcrumb">
            <li class="white">
                <a href="{{ route('home') }}" class="white"> 
                    <ion-icon name="home-outline" class="white"></ion-icon> Home
                </a>
            </li>
            <li class="white"><a href="{{ route('categories') }}" class="white">Game Categories</a></li>
            <li class="white"> {{ $category->name }}</li>
        </ul>
    </div>
   <article class="category-section">
        <div class="category-section-total" data-cat="{{$category->id}}">
            <h1 class="category-title white">{{ $category->name }}</h1>
            <div class="category-description">
                <h2> Description </h2>
                <p>{{ $category->description }}</p>
            </div>
            <div class="category-games">
                <div class="games-group d-flex flex-row justify-content-between pe-4">
                    <h2> Games </h2>
                    <div class="games-action">
                        @if (Auth::check())
                            @if (Auth::user()->is_admin && !Auth::user()->is_banned)
                                <a href="{{ route('games.create', ['category_id' => $category->id]) }}" id="newQuestion">Create New Game</a>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="games-grid">
                    @if ($category->games->count() > 0)
                        @foreach($category->games as $game)
                            <a href="{{ route('game', ['id' => $game->id]) }}" class="game-card">
                                <img src="../images/roblox.jpg" alt="game-image"></img>
                            </a>
                        @endforeach
                    @else
                        <div class="no-games mx-auto">
                            <p>This game category doesn't have any games added yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>  
    </article>
@endsection