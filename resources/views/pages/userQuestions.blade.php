@extends('layouts.app')

@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="{{ route('users') }}">Users</a></li>
        <li><a href="{{ route('profile', ['id' => $user->id]) }}">{{ $user->username }}</a></li>
        @if(Auth::check() and (Auth::id() == $user->id))
            <li>my questions</li>
        @else
            <li>{{ $user->username }} questions</li>
        @endif
    </ul>

    <div class="user-questions">
        @if(Auth::check() and (Auth::id() == $user->id))
            <div class="title-user-questions-auth">
                <h1>My Questions </h1>
            </div>
        @else
            <div class="title-user-questions">
                <h1> {{ $user->username }}'s Questions</h1>
            </div>
        @endif

        <div class="questions">
            @if($questions->count() > 0)
                @foreach($questions as $question)
                <li class="question-card" id={{ $question->id }}>
                    <div class="q-stats">
                        <span>{{ $question->votes }} votes</span>
                        <span>{{ $question->answers->count() }} answers</span>
                        <span>{{ $question->nr_views }} views</span>
                    </div>
                    <div class="q-content">
                        <a href=""> <h2>{{ $question->title }}</h2> </a>
                        <p>{{ $question->latest_content() }}</p>
                        <span><a href="{{ route('profile', ['id' => $user->id]) }}" class="purple">{{ $question->creator->username }}</a> asked 10 minutes ago</span>
                    </div>
                    @if(Auth::check() and (Auth::id() == $user->id) and Auth::user()->is_admin)
                        <div class="q-delete">
                            <button class="delete-button" onclick="deleteQuestion({{ $question->id }})">Delete</button>
                        </div>
                    @endif
                </li>
                @endforeach
            @else
                <div class="no-questions">
                    <img class="no-questions-image" src="{{ asset('images/pikachuConfused.png') }}" alt="Psyduck Image">
                    @if(Auth::check() and (Auth::id() == $user->id))
                        <p>You haven't asked any questions yet.</p>
                    @else
                        <p>{{ $user->username }} haven't asked any questions yet.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>


@endsection