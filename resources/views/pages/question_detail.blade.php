@extends('layouts.app')

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="{{ route('questions') }}">Questions</a></li>
        <li>id</li>
    </ul>

    <section class="question-detail-section" data-id="{{$question->id}}">
        <div class="question-detail">
            <div class="question-title">
                <img src="../images/user.png" alt="user">
                <h1> {{ $question->title }} </h1>
                @auth
                    <button class="answer" onclick="toggleAnswerForm()">Answer</button>
                @else
                    <button class="answer" onclick="showLoginModal()">Answer</button>
                @endauth
            </div>


            @php
            $user = Auth::user();

            @endphp

            
            <div class="question-t">
                <div class="vote-btns">
                    @auth
                        <button class="up-vote">
                            <ion-icon id="up" class="{{ $user->hasVoted($question->id) && ($user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}  {{ $user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo') }}" name="caret-up"></ion-icon>
                        </button>
                        <span>{{ $question->votes }} </span>
                        <button class="down-vote">
                            <ion-icon id="down" class="{{ ($user->hasVoted($question->id) && !$user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }} {{ $user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo') }}" name="caret-down"></ion-icon>
                        </button>
                    @else
                        <button class="" onclick="showLoginModal()">
                            <ion-icon id="" class="notvoted" name="caret-up"></ion-icon>
                        </button>
                        <span>{{ $question->votes }} </span>
                        <button class="" onclick="showLoginModal()">
                            <ion-icon id="" class="notvoted" name="caret-down"></ion-icon>
                        </button>
                    @endauth
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
        <div id="answerFormContainer" class="answerFormContainer" style="display: none;">
            @auth
                <form action="{{ route('store_answer') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="content">Answer <span>*</span></label>
                        <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                        <input type="hidden" name="questionId" id="questionId" value="{{ $question->id }}">
                        <textarea name="content" id="content" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Answer</button>
                </form>
            @else
            @endauth
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
                                    @auth
                                        <form action="{{ route('store_comment') }}" method="post">
                                            @csrf
                                            <div class="comment-input">
                                                <img src="../images/user.png" alt="user">
                                                <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                                                <input type="hidden" name="questionId" id="questionId" value="{{ $question->id }}">
                                                <input type="hidden" name="answerId" id="answerId" value="{{ $topAnswer->id }}">
                                                <input type="text" id="commentario" name="commentario" placeholder="Add new comment">
                                                <button type="submit">
                                                    <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                    @endauth
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if ($question->answers->count() > 1)
                <div class="other-answers">
                    <h2>Other answers</h2>
                    @foreach ($question->answers->where('id', '!=', $topAnswer->id) as $otherAnswer)
                        <div class="answer-details">
                            <div class="vote-btns">
                            </div>
                            <div class="answer-content"> 
                                <div>
                                    <img src="../images/user.png" alt="user">
                                    <p>
                                        {{ $otherAnswer->latest_content() }}
                                    </p>
                                </div>
                                <ul>
                                    <li> <a href="#" class="purple">{{ $otherAnswer->creator->name }}</a> answered {{ calculateTimePassed($otherAnswer->created_at) }}</li>
                                    <li> Modified {{ calculateTimePassed($otherAnswer->created_at) }}</li>
                                    <li> Viewed {{ $otherAnswer->nr_views }} times </li>
                                </ul>
                                <div class="answer-comments">
                                    <ul id="answer-comment-list">
                                        @foreach ($otherAnswer->comments as $comment)
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
                                        @auth
                                            <form action="{{ route('store_comment') }}" method="post">
                                                @csrf
                                                <div class="comment-input">
                                                    <img src="../images/user.png" alt="user">
                                                    <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                                                    <input type="hidden" name="questionId" id="questionId" value="{{ $question->id }}">
                                                    <input type="hidden" name="answerId" id="answerId" value="{{ $otherAnswer->id }}">
                                                    <input type="text" id="commentario" name="commentario" placeholder="Add new comment">
                                                    <button type="submit">
                                                        <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                        @endauth
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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

    <script>
        function toggleAnswerForm() {
            var answerFormContainer = document.getElementById('answerFormContainer');
            answerFormContainer.style.display = (answerFormContainer.style.display === 'none' || answerFormContainer.style.display === '') ? 'block' : 'none';
        }

        function showLoginModal() {
            document.getElementById('loginModal').style.display = 'block';

            document.querySelectorAll('.close').forEach(function (closeButton) {
                closeButton.addEventListener('click', function () {
                    document.getElementById('loginModal').style.display = 'none';
                });
            });
        }
    </script>


@endsection


@php
    function calculateTimePassed($inputDate)
    {
        $inputDate = \Carbon\Carbon::parse($inputDate);
        $diff = $inputDate->diffForHumans();

        return $diff;
    }
@endphp