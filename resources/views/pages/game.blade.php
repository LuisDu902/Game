@extends('layouts.app')

@section('content')
    <ul class="breadcrumb">
        <li class="white">
            <a href="{{ route('home') }}" class="white"> 
                <ion-icon name="home-outline" class="white"></ion-icon> Home
            </a>
        </li>
        <li class="white"><a href="{{ route('categories') }}" class="white">Game Categories</a></li>
        <li class="white"><a href="{{ route('category', ['id' => $game->category->id]) }}" class="white">{{ $game->category->name }}</a></li>
        <li class="white"> {{ $game->name }}</li>
    </ul>

   <article class="game">
        <img src="../images/roblox.jpg" alt="game image" class="game-img">

        <div class="flex">
            <h1>{{ $game->name }}</h1>
            <button class="join-btn">Join game</button>
        </div>
        <p class="g-desc">{{ $game->description }}</p>
        <ul class="g-stats">
            <li> 1 062 219 Members </li>
            <li> 180 869 Question </li>
            <li> 1 062 219 Answers </li>
            <li> 10 062 219 Votes </li>
        </ul>

        
    </article>
   
@endsection