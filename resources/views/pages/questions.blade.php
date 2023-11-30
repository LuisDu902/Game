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
            <a href="{{ route('questions.create') }}" id="newQuestion">Ask Question</a>
        </div>
        <div class="questions-list">
            @include('partials._questions')
        <div>
    </section>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('newQuestion').addEventListener('click', function(event) {
                if (!userIsLoggedIn()) {
                    event.preventDefault();
                    document.getElementById('loginModal').style.display = 'block';
                }
            });

            function userIsLoggedIn() {
                return {{ Auth::check() ? 'true' : 'false' }};
            }

            document.querySelectorAll('.close').forEach(function(closeButton) {
                closeButton.addEventListener('click', function() {
                    document.getElementById('loginModal').style.display = 'none';
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target === document.getElementById('loginModal')) {
                    document.getElementById('loginModal').style.display = 'none';
                }
            });
        });
    </script>

@endsection