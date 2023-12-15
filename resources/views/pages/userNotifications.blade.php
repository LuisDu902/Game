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
            <li><a href="{{ route('users') }}">Users</a></li>
            <li><a href="{{ route('profile', ['id' => $user->id]) }}">{{ $user->username }}</a></li>
            <li>notifications</li>
        </ul>
    </div>
    <section class="activity-section">
        <div class="user-answers">
            <div class="title-user-answers-auth">
                <h1>Notifications </h1>
            </div>
        </div>
        <div class="activities">
        @foreach ($notifications as $notification) 
            @if ($notification->notification_type != 'Report_notification')
                @if ($notification->viewed)
                    <div class="activity-wrap Viewd_content">
                @else
                    <div class="activity-wrap Question_content">
                @endif
                        <span class="circle">{{ $notification->notification_type[0] }}</span>
                        <div class="activity">
                            @if ($notification->notification_type === 'Question_notification')
                                <h2>Question notification</h2>
                                <p class="version-content">{{ $notification->question->latestContent() }}</p>
                                <span class="date">{{ $notification->question->creator->name }} <span class="type">questioned</span> at {{ $notification->date }}</span>
                            @elseif ($notification->notification_type === 'Answer_notification')
                                <h2>Answer notification</h2>
                                <p class="version-content">{{ $notification->answer->latestContent() }}</p>
                                <span class="date">{{ $notification->answer->creator->name }} <span class="type">answered</span> to your question at {{ $notification->date }}</span>
                            @elseif ($notification->notification_type === 'Comment_notification')
                                <h2>Comment notification</h2>
                                <p class="version-content">{{ $notification->comment->latestContent() }}</p>
                                <span class="date">{{ $notification->comment->creator->name }} <span class="type">commented</span> on your answer at {{ $notification->date }}</span>
                            @elseif ($notification->notification_type === 'Rank_notification')
                                <h2>Rank notification</h2>
                                <span class="date"><span class="type"></span></span>
                                <span class="date">At {{ $notification->date }}</span>
                            @elseif ($notification->notification_type === 'Vote_notification')
                                <h2>Vote notification</h2>
                                @if ($notification->vote->vote_type === "Question_vote")
                                    <p class="version-content">Someone voted on your <a href="{{ route('question', ['id' => $notification->vote->question_id]) }}">question</a></p>
                                    <span class="date">{{ $notification->vote->creator->name }} <span class="type">voted</span> on your question at {{ $notification->date }}</span>
                                @elseif ($notification->vote->vote_type === "Answer_vote")
                                    <p class="version-content">Someone voted on your <a href="{{ route('question', ['id' => $notification->vote->answer_id]) }}">answer</a></p>
                                    <span class="date">{{ $notification->vote->creator->name }} <span class="type">voted</span> on your answer at {{ $notification->date }}</span>
                                @endif
                            @elseif ($notification->notification_type === 'Badge_notification')
                                <h2>Badge notification</h2>
                                <p class="version-content">You have received a new badge. Check them out in your profile page!</p>
                                <span class="date">At {{ $notification->date }}</span>
                            @elseif ($notification->notification_type === 'Game_notification')
                                <h2>Game notification</h2>
                                <p class="version-content">New content was added to the game you follow. Check it out at <a href="{{ route('game', ['id' => $notification->game->id]) }}">{{$notification->game->id }}</a></p>
                                <span class="date">At {{ $notification->date }}</span>
                            @endif
                        </div>
                    </div>
            @endif
        @endforeach
        </div>
    </section>

@endsection
