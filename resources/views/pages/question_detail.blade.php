
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
            <li>{{ $question->id }}</li>
        </ul>
    </div>
    <section class="question-detail-section" data-id="{{$question->id}}" {{ Auth::check() ? 'data-user=' . Auth::id() . ' data-username=' . Auth::user()->name . '' : '' }}>
        <div class="question-detail">
            <div class="question-title">
                <img src="../images/user.png" alt="user">
                <h1> {{ $question->title }} </h1>
                @if (Auth::check())
                    @if(Auth::check() and (Auth::id() == $question->user_id))
                        <button class="edit-question">Edit</button>
                    @else
                        <button class="follow">Follow</button>
                    @endif
                @endif
            </div> 

            <div class="question-t">
                <div class="vote-btns">
                    @if (Auth::check())
                        <button class="up-vote">
                            <ion-icon id="up" class= "{{ Auth::user()->hasVoted($question->id) && (Auth::user()->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}" name="caret-up" ></ion-icon>
                        </button>
                        <span>{{ $question->votes }}</span>
                        <button class="down-vote">
                            <ion-icon id="down" class= "{{ ((Auth::user()->hasVoted($question->id)) && !Auth::user()->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} " name="caret-down" ></ion-icon>
                        </button>
                    @else 
                        <button class="up-vote">
                            <ion-icon class="no-up notvoted" name="caret-up" ></ion-icon>
                        </button>
                        <span>{{ $question->votes }}</span>
                        <button class="down-vote">
                            <ion-icon class="no-down notvoted" name="caret-down" ></ion-icon>
                        </button>
                    @endif
                </div>

                <div class="question-description"> 
                    <ul>
                        <li> <a href="{{ route('profile', ['id' => $question->creator->id ]) }}" class="purple">{{ $question->creator->name }}</a> asked {{ $question->timeDifference() }} ago</li>
                        <li id="q-modi"> Modified {{ $question->lastModification() }} ago</li>
                        <li> Viewed {{ $question->nr_views }} times </li>
                        <li> Show <a href="#" class="purple">post activity</a> </li>
                    </ul>
                    <p>
                        {{ $question->latestContent() }}
                    </p>
                </div>
            </div>
        </div>
      

        @if ($question->answers->isNotEmpty())
            <div class="top-answer">
                <h2>Top answer</h2>
                @include('partials._answer', ['answer' => $question->topAnswer()])
            </div>
                <div class="other-answers">
                    @if ($question->otherAnswers()->isNotEmpty())
                        <h2>Other answers</h2>
                        @foreach ($question->otherAnswers() as $answer)
                            @include('partials._answer', ['answer' => $answer])
                        @endforeach
                    @endif
                </div>
        @elseif (Auth::check() && Auth::user()->id !== $question->user_id)  
        @else
            <div class="no-answers">
                <img class="no-answers-image" src="{{ asset('images/pikachuConfused.png') }}" alt="Psyduck Image">
                <p>No answers for this question yet.</p>
            </div>
            <div class="other-answers">
            </div>
        @endif
        <div id="answerFormContainer" class="answerFormContainer">
            <form>
                <div class="form-group">
                    <label for="content">Answer <span>*</span></label>
                    <textarea name="content" id="content" class="form-control" placeholder="Enter your answer here..." required></textarea>
                </div>
                <button class="btn btn-primary">Post Answer</button>
            </form>
        </div>
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
