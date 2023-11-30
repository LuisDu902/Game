@extends('layouts.app')

@section('content')
    <ul class="breadcrumb">
        <li>
            <a href="{{ route('home') }}"> 
                <ion-icon name="home-outline"></ion-icon> Home
            </a>
        </li>
        <li><a href="{{ route('questions') }}">Questions</a></li>
        <li>New Question</li>
    </ul>
    <div class="new-question-form">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Title <span>*</span></label>
                <textarea name="title" id="title" class="form-control" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="content">Description <span>*</span></label>
                <textarea name="content" id="content" class="form-control" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="game">Game <span>*</span></label>
                <select name="game_id" id="game_id" class="form-control" required>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Post Question</button>
        </form>
    </div>
@endsection
