@extends('layouts.app')

@section('content')

<ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="{{ route('users') }}">Users</a></li>
        <li><a href="{{ route('profile', ['id' => $user->id]) }}">{{ $user->username }}</a></li>
        @if(Auth::check() and (Auth::id() == $user->id))
            <li>my answers</li>
        @else
            <li>{{ $user->username }} answers</li>
        @endif
    </ul>

<div class="user-answers">
    @if(Auth::check() and (Auth::id() == $user->id))
        <div class="title-user-answers-auth">
            <h1>My Answers </h1>
        </div>
    @else
        <div class="title-user-answers">
            <h1> {{ $user->username }}'s Answers</h1>
        </div>
    @endif

    <div class="answers">
        @if($answers->count() > 0)
            @foreach($answers as $answer)
            <li class="answer-card">
                <a href="" > <span> <strong class="purple">Question</strong>: <span>{{ $answer->question->title }}</span> </span></a>
                <p>{{ $answer->latest_content() }}</p>
                <ul class="answer-stats">
                    <li> Answered {{ $answer->time_difference() }} ago </li>
                    <li> Modified {{ $answer->last_modification() }} ago </li>
                    <li> {{ $answer->comments->count() }} Comments </li>
                    <li> {{ $answer->votes }} votes </li>
                </ul>
            </li>
            @endforeach
        @else
            <div class="no-questions">
                <img class="no-questions-image" src="{{ asset('images/pikachuConfused.png') }}" alt="Psyduck Image">
                @if(Auth::check() and (Auth::id() == $user->id))
                    <p>You haven't answered any question yet.</p>
                @else
                    <p>{{ $user->username }} haven't answered any question yet.</p>
                @endif
            </div>
        @endif
    </div>

</div>

@endsection
