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

        <form class="profile-right">
            <div class="profile-input">
                <label class="field-label" for="name"> Name <span
                        class="purple">*</span> </label>
                <input type="text" name="name" placeholder="{{ Auth::user()->name }}"
                    required disabled>
            </div>

            <div class="profile-input">
                <label class="field-label" for="username"> Username
                    <span class="purple">*</span> </label>
                <input type="text" name="username" placeholder="{{ Auth::user()->username }}"
                    required disabled>
            </div>

            <div class="profile-input email">
                <label class="field-label" for="email"> Email Address
                    <span class="purple">*</span> </label>
                <input type="email" name="email"
                    placeholder="{{ Auth::user()->email }}" required disabled>
            </div>
            <div class="profile-input description">
                <label class="field-label" for="description">
                    Description </label>
                <textarea name="description"
                    placeholder="{{ Auth::user()->description }}"
                    required disabled></textarea>
            </div>
        </form>

    </article>
@endsection