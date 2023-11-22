@extends('layouts.app')


@section('content')

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 

 <div class="container mt-5" data-id="{{$question->id}}">
        <div class="row justify-content-end align-items-start"> <!-- Adjusted row classes -->
            <div class="col-md-6 col-sm-12 order-md-1 order-sm-2"> <!-- Adjusted column classes -->
            
            @php
            $user = Auth::user();

            @endphp

                
                <div>
                    <ion-icon id="up" class= "{{ $user->hasVoted($question->id) && ($user->voteType($question->id)) ? 'hasvoted' : 'notvoted' }}  {{$user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo');
 }}" name="caret-up"></ion-icon>
                </div>


                    
                <div id="votes">{{ $question->votes }}</div>

                <div>
                    <ion-icon id="down" class= "{{ (($user->hasVoted($question->id)) && !$user->voteType($question->id) ) ? 'hasvoted' : 'notvoted' }} {{$user->voteType($question->id) === true ? 'cima' : ($user->voteType($question->id) === false ? 'baixo' : 'nulo');
 }} " name="caret-down"></ion-icon>
                </div>
                
                <div class="profile-container">
                    <img id="profile_pic" src="../images/question_profile_pic.png" alt="User Image">
                    <h1 class="question_info">{{ $question->title }}</h1>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 order-md-2 order-sm-1"> <!-- Adjusted column classes -->
                <button class="answer">Answer</button>
            </div>
        </div>

            <div class="col-md-6 col-sm-12">
                        <div class="info">
                            <div class="line-container" id="first_info">
                                <span id="user_name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                                        <circle cx="4.5" cy="4.5" r="4.5" fill="#7C5BF0"/>
                                    </svg>
                                    {{ $question->creator->name }}
                                    
                                </span>
                                <span> asked {{ calculateTimePassed($question->create_date) }}</span>
                            </div>

                            <div class="line-container" id="second_info">
                                <span style=" margin-right: 5px;  margin-left: 5px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                                        <circle cx="4.5" cy="4.5" r="4.5" fill="#7C5BF0"/>
                                    </svg>
                                </span>
                                <span>  Viewed {{ $question->nr_views }} times</span>
                            </div>   
                        </div>
                        <svg style="margin-top: 10px; margin-bottom: 20px;"xmlns="http://www.w3.org/2000/svg" width="1173" height="8" viewBox="0 0 1173 8" fill="none">
                            <path d="M0 7L1173 1" stroke="black" stroke-opacity="0.14"/>
                        </svg>
                        <p class="content">{{ $question->latest_content() }}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1173" height="8" viewBox="0 0 1173 8" fill="none">
                            <path d="M0 7L1173 1" stroke="black" stroke-opacity="0.14"/>
                        </svg>
            </div>
        </div>
    </div>






@endsection

@php
    function calculateTimePassed($inputDate)
    {
        $inputDate = \Carbon\Carbon::parse($inputDate);
        $diff = $inputDate->diffForHumans();

        return $diff;
    }
@endphp


