@extends('layouts.app')

@section('content')
    <x-sidebar></x-sidebar>

    <div class="headers">
        <button class="open-sidebar">
            <ion-icon name="menu"></ion-icon>
        </button>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('home') }}"> 
                    <ion-icon name="home-outline"></ion-icon> Home
                </a>
            </li>
            <li><a href="{{ route('questions') }}">Questions</a></li>
            <li>New Question</li>
        </ul>
    </div>
    <div class="new-question-form">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title <span>*</span></label>
                <textarea name="title" id="title" class="form-control" placeholder="Question title..." required></textarea>
            </div>
            
            <div class="form-group">
                <label for="content">Description <span>*</span></label>
                <textarea name="content" id="content" class="form-control" placeholder="Question description..." required></textarea>
            </div>
            
            <div class="form-grid">
                <label for="game">Game: </label>
                <select name="game_id" id="game_id" class="form-control" required>
                    <option value="None" selected>None</option>
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->games as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <label for="tags">Tags: </label>
                <div class="tag-con">
                    <select name="tag_id" id="tag_id" class="form-control" required>
                        <option value="None" selected>None</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <div class="tag-btns">
                        <button id="create-tag">Create new tag</button>
                    </div>
                </div>
                <div class="new-tags"></div>
            </div>
            <button type="submit" class="btn btn-primary">Post Question</button>
        </form>
    </div>
@endsection
