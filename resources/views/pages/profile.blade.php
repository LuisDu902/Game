@extends('layouts.app')

@section('content')
   
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="{{ route('users') }}">Users</a></li>
        <li> {{ $user->username }} </li>
    </ul>

    <article class="profile-wrapper">
        <div class="profile-left">
            <img class="profile-big-pic" src="../images/user.png"
                alt="Gengar's Image">

            <div class="stats-grid">
                <div class="stats-text">Rank:</div>
                <div class="user-rank">{{ $user->rank }}</div>
                <div class="stats-text">Badges:</div>
                <div class="user-badges">
                    @if($badges && count($badges) > 0)
                        <ul>
                            @foreach($badges as $badge)
                                <li>{{ $badge->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No badges</p>
                    @endif
                </div>
            </div>

        </div>

        <form id="profileForm" class="profile-right" method="POST" enctype="multipart/form-data" data-id="{{ $user->id }}">
            {{ csrf_field() }}
            <div class="profile-input name">
                <label class="field-label" for="name"> Name <span
                        class="purple">*</span> </label>
                <input id="profile-name" type="text" name="name" value="{{ $user->name }}" placeholder="your name"
                    required disabled>
            </div>

            <div class="profile-input username">
                <label class="field-label" for="username"> Username
                    <span class="purple">*</span> </label>
                <input id="profile-username" type="text" name="username" value="{{ $user->username }}" placeholder="your username"
                    required disabled>
            </div>

            <div class="profile-input email">
                <label class="field-label" for="email"> Email Address
                    <span class="purple">*</span> </label>
                <input id="profile-email" type="email" name="email" value="{{ $user->email }}"
                    placeholder="email@example.com" required disabled>
            </div>
            <div class="profile-input description">
                <label class="field-label" for="description">
                    Description </label>
                    <textarea id="profile-description" name="description" placeholder="Your description" disabled>{{ $user->description }}</textarea>
                </div>
        </form>

    </article>

    @if(Auth::check() and (Auth::id() == $user->id))
        <div class="edit-profile-button">
            <button class="edit-button" onclick="toggleEdit()">Edit my Profile</button>
        </div>
        
        <div class="edit-profile-buttons">
            <button class="save-button" type="submit" id="edit_profile" onclick="saveChanges()">Save</button>
            <button class="cancel-button" onclick="cancelChanges()">Cancel</button>
        </div>

    @else
        <div class="user-questions-answers-profile d-flex flex-row gap-4 mx-auto">
            <a href="{{ route('users_questions', ['id' => $user->id]) }}" class="purple"> {{ $user->username }} questions </a>
            <div class="vl"></div>
            <a href="{{ route('users_answers', ['id' => $user->id]) }}" class="purple"> {{ $user->username }} answers </a>
        </div>
    @endif
@endsection