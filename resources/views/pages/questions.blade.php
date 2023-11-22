@extends('layouts.app')

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li> Questions</li>
    </ul>
    <section class="questions-sec">
        <div class="questions-actions">
            <div class="questions-sort">
                <button class="selected" id="recent">Recent</button>
                <button id="popular">Popular</button>
                <button id="unanswered">Unanswered</button>
            </div>
            <a href="{{ route('questions.create') }}" id="newQuestion">Ask Question</a>
        </div>
        <div class="questions-list">
            @include('partials._questions')
        <div>
    </section>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <div class="title-section">
                <span class="close">&times;</span>
                <h2>Authentication required</h2>
            </div>
            <p>Please log in to ask a question.</p>
            <div class="loginModalButtons">
                <a href="{{ route('register') }}">
                    <button class="sign-up-btn-modal">Sign Up</button></a>
                <a href="{{ route('login') }}">
                    <button class="sign-in-btn-modal">Sign In</button></a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#newQuestion').click(function(event) {
                if (!userIsLoggedIn()) {
                    event.preventDefault();
                    
                    $('#loginModal').css('display', 'block');
                }
            });

            function userIsLoggedIn() {
                return {{ Auth::check() ? 'true' : 'false' }};
            }

            $('.close').click(function() {
                $('#loginModal').css('display', 'none');
            });

            $(window).click(function(event) {
                if (event.target == $('#loginModal')[0]) {
                    $('#loginModal').css('display', 'none');
                }
            });
        });
    </script>
@endsection
