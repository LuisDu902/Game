@extends('layouts.app')

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="{{ route('questions') }}">Questions</a></li>
        <li>id</li>
    </ul>

    <section class="question-detail-section" data-id="{{$question->id}}" data-user="{{ Auth::id() }}" data-username= "{{Auth::user()->username}}">
        <div class="question-detail">
            <div class="question-title">
                <img src="../images/user.png" alt="user">
                <h1> {{ $question->title }} </h1>
                @if(Auth::check() and (Auth::id() == $question->user_id))
                    <button class="edit-question">Edit</button>
                @else
                    <button class="answer">Answer</button>
                @endif
            </div>

            @php $user = Auth::user(); @endphp

            <div class="question-t">
                <div class="vote-btns">
                    <button class="up-vote">
                        <ion-icon id="up" class= "{{ $user->hasVoted($question->id) && ($user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}  {{$user->voteType($question->id) ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo') }}" name="caret-up"></ion-icon>
                    </button>
                    <span>{{ $question->votes }} </span>
                    <button class="down-vote">
                        <ion-icon id="down" class= "{{ (($user->hasVoted($question->id)) && !$user->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} {{$user->voteType($question->id) ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo') }} " name="caret-down"></ion-icon>
                    </button>
                </div>
                <div class="question-description"> 
                    <ul>
                        <li> {{ $question->creator->name }} asked {{ calculateTimePassed($question->create_date) }}</li>
                        <li> Modified {{ calculateTimePassed($question->create_date) }}</li>
                        <li> Viewed {{ $question->nr_views }} times </li>
                    </ul>
                    <p>
                    {{ $question->latest_content() }}
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
    </section>
@endsection


@php
    function calculateTimePassed($inputDate)
    {
        $inputDate = \Carbon\Carbon::parse($inputDate);
        $diff = $inputDate->diffForHumans();

        return $diff;
    }
@endphp