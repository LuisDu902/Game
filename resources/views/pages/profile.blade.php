@extends('layouts.app')

@section('content')
   
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li><a href="#">User Profile</a></li>
        <li> {{ Auth::user()->username }} </li>
    </ul>

    <article class="profile-wrapper">
        <div class="profile-left">
            <img class="profile-big-pic" src="../images/user.png"
                alt="Gengar's Image">

            <div class="stats-grid">
                <div class="stats-text">Rank:</div>
                <div class="user-rank">{{ Auth::user()->rank }}</div>
                <div class="stats-text">Badges:</div>
                <div class="user-badges">{{ Auth::user()->badges }}</div>
            </div>

        </div>

        <form id="profileForm" class="profile-right" method="POST" enctype="multipart/form-data" data-id="{{ Auth::user()->id }}">
            {{ csrf_field() }}
            <div class="profile-input">
                <label class="field-label" for="name"> Name <span
                        class="purple">*</span> </label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" placeholder="your name"
                    required disabled>
            </div>

            <div class="profile-input">
                <label class="field-label" for="username"> Username
                    <span class="purple">*</span> </label>
                <input type="text" name="username" value="{{ Auth::user()->username }}" placeholder="your username"
                    required disabled>
            </div>

            <div class="profile-input email">
                <label class="field-label" for="email"> Email Address
                    <span class="purple">*</span> </label>
                <input type="email" name="email" value="{{ Auth::user()->email }}"
                    placeholder="email@example.com" required disabled>
            </div>
            <div class="profile-input description">
                <label class="field-label" for="description">
                    Description </label>
                    <textarea name="description" placeholder="Your description" disabled>{{ Auth::user()->description }}</textarea>
                </div>
        </form>

    </article>

    <div class="edit-profile-button">
        <button class="edit-button" onclick="toggleEdit()">Edit my Profile</button>
    </div>

    <div class="edit-profile-buttons d-none mx-auto">
        <button class="save-button" type="submit" id="edit_profile" onclick="saveChanges()">Save</button>
        <button class="cancel-button" onclick="cancelChanges()">Cancel</button>
    </div>
@endsection