@extends('layouts.app')

@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="{{ route('users') }}">Users</a></li>
        <li> {{ $user->username }} </li>
    </ul>

    <div class="user-questions">
        <div class="title-user-questions">
            <h1>My Questions </h1>
        </div>

        <div class="questions">
            @foreach($questions as $question)
            <li class="question-card">
                <div class="q-stats">
                    <span>{{ $question->votes }} votes</span>
                    <span>{{ $question->answers->count() }} answers</span>
                    <span>{{ $question->nr_views }} views</span>
                </div>
                <div class="q-content">
                    <h2>{{ $question->title }}</h2>
                    <p>{{ $question->latest_content() }}</p>
                    <span><a href="#" class="purple">{{ $question->creator->username }}</a> asked 10 minutes ago</span>
                </div>
            </li>
        @endforeach
        </div>
    </div>


@endsection