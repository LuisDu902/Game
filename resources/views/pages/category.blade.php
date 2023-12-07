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
        <h1 class="category-title white">{{ $category->name }}</h1>
        <div class="category-description">
            <h2> Description </h2>
            <p>{{ $category->description }}</p>
        </div>
        <div class="category-games">
            <h2> Games </h2>
            <div class="games-grid">
                @foreach($category->games as $game)
                    <a href="{{ route('game', ['id' => $game->id]) }}" class="game-card">
                        <img src="../images/roblox.jpg" alt="game-image"></img>
                    </a>
                @endforeach
            </div>
        </div>
        
    </article>
@endsection