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
                <button class="answer" onclick="toggleAnswerForm()">Answer</button>
            </div>


            @php
            $user = Auth::user();

            @endphp

            
            <div class="question-t">
                <div class="vote-btns">
                    <button class="up-vote">
                        <ion-icon id="up" class= "{{ $user->hasVoted($question->id) && ($user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}  {{$user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo');
 }}" name="caret-up"></ion-icon>
                    </button>
                    <span>{{ $question->votes }} </span>
                    <button class="down-vote">
                        <ion-icon id="down" class= "{{ (($user->hasVoted($question->id)) && !$user->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} {{$user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo');
 }} " name="caret-down"></ion-icon>
                    </button>
                </div>
                <div class="question-description"> 
                    <ul>
                        <li> {{ $question->creator->name }} asked {{ calculateTimePassed($question->create_date) }} </li>
                        <li> Viewed {{ $question->nr_views }} times </li>
                    </ul>
                    <p>
                    {{ $question->latest_content() }}
                    {{ $user->hasVoted($question->id) && ($user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }} 
                    {{$user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo');
 }}
                    </p>
                </div>

                
                
            </div>
        </div>
        <div id="answerFormContainer" class="answerFormContainer" style="display: none;">
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">Answer <span>*</span></label>
                    <textarea name="content" id="content" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Answer</button>
            </form>
        </div>
        <div class="top-answer">
            <h2>Top answer</h2>
            <div class="answer-details">
                <div class="vote-btns">
                    <button class="up-vote">
                        <ion-icon name="caret-up"></ion-icon>
                    </button>
                    <span>123 </span>
                    <button class="down-vote">
                        <ion-icon name="caret-down"></ion-icon>
                    </button>
                </div>
                <div class="answer-content"> 
                    <div>
                        <img src="../images/user.png" alt="user">
                        <p>
                            Midjourney is a new emerging text-to-image AI that brings your imagination into reality. Simply submit a text prompt and the bot will generate a beautiful.
                        </p>
                    </div>
                    <ul>
                        <li> <a href="#" class="purple">Gengy</a> asked 9 months ago</li>
                        <li> Modified 9 months ago</li>
                        <li> 53 comments </li>
                    </ul>
                   <div class="answer-comments">
                        <ul id="answer-comment-list">
                            <li>
                                <div>
                                    <img src="../images/user.png" alt="user">
                                    <a href="" class="purple">Regente de PFL</a>
                                </div>
                                <p>
                                    Sim sim, tem toda a razão.
                                </p>
                                <div class="like-comment">
                                    <ion-icon name="heart-circle-outline"></ion-icon>
                                    <span>12</span>
                                    <ion-icon name="heart-dislike-circle-outline"></ion-icon>
                                    <span>12</span>
                                </div>
                            </li>
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
       <div class="other-answers">
        <h2>Other answers</h2>
        <div class="answer-details">
            <div class="vote-btns">
                <button class="up-vote">
                    <ion-icon name="caret-up"></ion-icon>
                </button>
                <span>123 </span>
                <button class="down-vote">
                    <ion-icon name="caret-down"></ion-icon>
                </button>
            </div>
            <div class="answer-content"> 
                <div>
                    <img src="../images/user.png" alt="user">
                    <p>
                        Midjourney is a new emerging text-to-image AI that brings your imagination into reality. Simply submit a text prompt and the bot will generate a beautiful.
                    </p>
                </div>
                <ul>
                    <li> <a href="#" class="purple">Gengy</a> asked 9 months ago</li>
                    <li> Modified 9 months ago</li>
                    <li> 53 comments </li>
                </ul>
               <div class="answer-comments">
                    <ul id="answer-comment-list">
                        <li>
                            <div>
                                <img src="../images/user.png" alt="user">
                                <a href="" class="purple">Regente de PFL</a>
                            </div>
                            <p>
                                Sim sim, tem toda a razão.
                            </p>
                            <div class="like-comment">
                                <ion-icon name="heart-circle-outline"></ion-icon>
                                <span>12</span>
                                <ion-icon name="heart-dislike-circle-outline"></ion-icon>
                                <span>12</span>
                            </div>
                        </li>
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
        <div class="answer-details">
            <div class="vote-btns">
                <button class="up-vote">
                    <ion-icon name="caret-up"></ion-icon>
                </button>
                <span>123 </span>
                <button class="down-vote">
                    <ion-icon name="caret-down"></ion-icon>
                </button>
            </div>
            <div class="answer-content"> 
                <div>
                    <img src="../images/user.png" alt="user">
                    <p>
                        Midjourney is a new emerging text-to-image AI that brings your imagination into reality. Simply submit a text prompt and the bot will generate a beautiful.
                    </p>
                </div>
                <ul>
                    <li> <a href="#" class="purple">Gengy</a> asked 9 months ago</li>
                    <li> Modified 9 months ago</li>
                    <li> 53 comments </li>
                </ul>
               <div class="answer-comments">
                    <ul id="answer-comment-list">
                        <li>
                            <div>
                                <img src="../images/user.png" alt="user">
                                <a href="" class="purple">Regente de PFL</a>
                            </div>
                            <p>
                                Sim sim, tem toda a razão.
                            </p>
                            <div class="like-comment">
                                <ion-icon name="heart-circle-outline"></ion-icon>
                                <span>12</span>
                                <ion-icon name="heart-dislike-circle-outline"></ion-icon>
                                <span>12</span>
                            </div>
                        </li>
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
 
    </section>

    <script>
        function toggleAnswerForm() {
            var answerFormContainer = document.getElementById('answerFormContainer');
            answerFormContainer.style.display = (answerFormContainer.style.display === 'none' || answerFormContainer.style.display === '') ? 'block' : 'none';
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