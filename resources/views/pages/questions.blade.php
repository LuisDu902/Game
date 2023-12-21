@extends('layouts.app')

@section('content')
    @if (session()->has('delete'))
        <div class="notification-box" id="delete-noti"> 
            <ion-icon name="checkmark-circle" id="noti-icon"></ion-icon>
            <div>
                <span> Question deleted!</span>
                <span> {{ session('delete') }} </span>
            </div>
            <ion-icon name="close" id="close-notification" onclick="closeNotification()"></ion-icon>
        </div>
    @endif
    <x-sidebar></x-sidebar>

    <div class="headers">
        <button class="open-sidebar">
            <ion-icon name="menu"></ion-icon>
        </button>
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">
                <ion-icon name="home-outline"></ion-icon> Home</a>
            </li>
            <li> Questions</li>
        </ul>
    </div>
    <section class="questions-sec">
        <div class="questions-actions">
            <div class="questions-sort">
                <button class="selected" id="recent">Recent</button>
                <button id="popular">Popular</button>
                <button id="unanswered">Unanswered</button>
            </div>
            @if (Auth::check())
                <a href="{{ route('questions.create') }}" id="newQuestion">Ask Question</a>
            @else
                <button id="newQuestion" onclick="showLoginModal()">Ask Question</button>
                <div id="loginModal" class="modal">
                    <div class="modal-content">
                        <ion-icon name="warning-outline"></ion-icon>
                        <h2>Authentication required</h2>
                        <p>Please sign up or sign in to continue</p>
                        <div>
                            <a href="{{ route('register') }}">
                                <button>Sign Up</button>
                            </a>
                            <a href="{{ route('login') }}">
                                <button>Sign In</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="questions-list">
            @include('partials._questions')
        <div>
    </section>
@endsection