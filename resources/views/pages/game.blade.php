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
            <li class="white"><a href="{{ route('category', ['id' => $game->category->id]) }}" class="white">{{ $game->category->name }}</a></li>
            <li class="white"> {{ $game->name }}</li>
        </ul>
    </div>

   <article class="game">
        <img src="../images/roblox.jpg" alt="game image" class="game-img">

        <div class="flex">
            <h1>{{ $game->name }}</h1>
        </div>
        <p class="g-desc">{{ $game->description }}</p>
        <ul class="g-stats">
            <li> {{ $game->members->count() }} Members </li>
            <li> {{ $game->questions->count() }} Question </li>
            <li> {{ $game->answers->first()->total_answers ?? 0 }} Answers </li>
            <li> {{ $game->votes->first()->total_votes ?? 0 }} Votes </li>
        </ul>
       
        <h2 class="q">Questions</h2>
        </div>
        <div class="questions-list">
            @include('partials._questions', ['questions' => $questions])
        <div>
    </article>
   
@endsection