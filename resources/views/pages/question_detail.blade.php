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
                <button class="answer">Answer</button>
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
            <div class="top-answer">
                <h2>Top answer</h2>
                @php
                    $topAnswer = $question->answers->sortByDesc('votes')->first();
                @endphp

                <div class="answer-details">
                    <div class="vote-btns">
                    </div>
                    <div class="answer-content"> 
                        <div>
                            <img src="../images/user.png" alt="user">
                            <p>
                            {{ $topAnswer->latest_content() }}
                            </p>
                        </div>
                        <ul>
                            <li> Viewed {{ $topAnswer->nr_views }} times </li>
                        </ul>
                        <div class="answer-comments">
                            <ul id="answer-comment-list">
                                @foreach ($topAnswer->comments as $comment)
                                    <li>
                                        <div>
                                            <img src="../images/user.png" alt="user">
                                            <a href="" class="purple">{{ $comment->user->name }}</a>
                                        </div>
                                        <p>
                                            {{ $comment->latest_content() }}
                                        </p>
                                    </li>
                                @endforeach
                                <li>
                                    <div class="comment-input">
                                        <img src="../images/user.png" alt="user">
                                        <input type="text" placeholder="Add new comment">
                                        <button>
                                            <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if ($question->answers->count() > 1)
                <div class="other-answers">
                    <h2>Other answers</h2>
                    @foreach ($question->answers->where('id', '!=', $topAnswer->id) as $answer)
                        @include('partials._answer', ['answer' => $answer])
                    @endforeach
                </div>
            @else
                <div class="no-answers">
                    <h2>No more answers for this question yet.</h2>
                </div>
            @endif
    @else
        <div class="no-answers">
            <h2>No answers for this question yet.</h2>
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