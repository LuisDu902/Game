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
            <li><a href="{{ route('users_notifications', ['id' => Auth::user()->id]) }}">notifications</a></li>
            <li>report notifications</li>
        </ul>
    </div>
    <section class="notifications-section">
        <div class="user-notifications">
            <div class="title-user-notifications-auth">
                <h1>Report Notifications</h1>
            </div>
        </div>
        <div class="notifications">
        @foreach ($notifications as $notification) 
            @if ($notification->notification_type === 'Report_notification')
                @if ($notification->viewed)
                    <div class="notification-wrap Viewd_content">
                @else
                    <div class="notification-wrap Question_content">
                @endif
                        <span class="circle">{{ $notification->notification_type[0] }}</span>
                        <div id="notification-{{ $notification->id }}" class="notification" data-id="{{ $notification->id }}">
                            <a class="notification" href="#">
                                <h2>Report notification</h2>
                                <p class="version-content">A report was made by some user.<span class="type">Check it out</span>!</p>
                                <span class="date">At {{ $notification->date }}</span>
                            </a>
                        </div>
                    </div>
            @endif
        @endforeach
        </div>
    </section>
@endsection


