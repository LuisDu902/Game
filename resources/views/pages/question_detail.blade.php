@extends('layouts.app')

@section('content')
    <x-sidebar></x-sidebar>

    <div class="headers">
        <button class="open-sidebar">
            <ion-icon name="menu"></ion-icon>
        </button>
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">
                <ion-icon name="home-outline"></ion-icon> Home</a>
            </li>
            <li><a href="{{ route('questions') }}">Questions</a></li>
            <li>id</li>
        </ul>
    </div>
    <section class="question-detail-section" data-id="{{$question->id}}" {{ Auth::check() ? 'data-user=' . Auth::id() . ' data-username=' . Auth::user()->username . '' : '' }}
        >
        <div class="question-detail">
            <div class="question-title">
                <img src="../images/user.png" alt="user">
                <h1> {{ $question->title }} </h1>
                @if (Auth::check())
                    @if(Auth::check() and (Auth::id() == $question->user_id))
                        <button class="edit-question">Edit</button>
                    @else
                        <button class="answer">Answer</button>
                    @endif
                @endif
            </div> 

            @php $user = Auth::user(); @endphp

            <div class="question-t">
                <div class="vote-btns">
                    @if (Auth::check())
                        <button class="up-vote">
                            <ion-icon id="up" class= "{{ $user->hasVoted($question->id) && ($user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}  {{$user->voteType($question->id) ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo') }}" name="caret-up" ></ion-icon>
                        </button>
                    @endif
                    <span>{{ $question->votes }}</span>
                    @if (Auth::check())
                    <button class="down-vote">
                        <ion-icon id="down" class= "{{ (($user->hasVoted($question->id)) && !$user->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} {{$user->voteType($question->id) ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo') }} " name="caret-down" ></ion-icon>
                    </button>
                    @endif
                </div>

                <div class="question-description"> 
                    <ul>
                        <li> {{ $question->creator->name }} asked {{ $question->timeDifference() }} ago</li>
                        <li id="q-modi"> Modified {{ $question->lastModification() }}</li>
                        <li> Viewed {{ $question->nr_views }} times </li>
                    </ul>
                    <p>
                        {{ $question->latestContent() }}
                    </p>
                </div>
            </div>
        </div>
      

        @if ($question->answers->isNotEmpty())

            @if ($question->hasTopAnswer())
                <div class="top-answer">
                    <h2>Top answer</h2>
                    @include('partials._answer', ['answer' => $question->topAnswer()])
                </div>
            @endif
                <div class="other-answers">
                    <h2>{{ $question->hasTopAnswer() ? 'Other answers' : 'Answers'}}</h2>
                    @if ($question->otherAnswers->isNotEmpty())
                        @foreach ($question->otherAnswers as $answer)
                            @include('partials._answer', ['answer' => $answer])
                        @endforeach
                    @else
                        <div class="no-answers">
                            <h2>No more answers for this question yet.</h2>
                        </div>
                    @endif
                </div>
        @else
            <div class="no-answers">
                <h2>No answers for this question yet.</h2>
            </div>
            <div class="other-answers">

            </div>
        @endif

        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Authentication required</h2>
                <p>Please log in to ask a question.</p>
                <div class="loginModalButtons">
                    <a href="{{ route('register') }}">
                        <button class="sign-up-btn-modal">Sign Up</button></a>
                    <a href="{{ route('login') }}">
                        <button class="sign-in-btn-modal">Sign In</button></a>
                </div>
            </div>
        </div>
    </section>
@endsection
