@extends('layouts.app')

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">
            <ion-icon name="home-outline"></ion-icon> Home</a>
        </li>
        <li>Users</li>
    </ul>

    <section class="user-manage-section">
        <h1>Users</h1>
        <nav class="search-bar">
            <div class="filter-condition">
                <ion-icon name="funnel-outline" class="purple"></ion-icon>
                <label> Filter by </label>
                <select name="" class="filter-select" id="filter-user">
                    <option value="">None</option>
                    <optgroup label="Rank">
                        <option value="Bronze">Bronze</option>
                        <option value="Gold">Gold</option>
                        <option value="Master">Master</option>
                    </optgroup>
                    <optgroup label="Status">
                        <option value="Active">Active</option>
                        <option value="Banned">Banned</option>
                    </optgroup>
                </select>
            </div>
            <div class="user-search">
                <ion-icon name="search" class="purple"></ion-icon>
                <input id="search-user" type="text" placeholder="Search...">
            </div>

            <div class="order-condition">
                <ion-icon name="swap-vertical" class="purple"></ion-icon>
                <label> Order by </label>
                <select name="" class="order-select" id="order-user">
                    <option value="username"> username </option>
                    <option value="name"> name </option>
                    <option value="rank"> rank </option>
                </select>
            </div>
            @if (Auth::check() && Auth::user()->is_admin && !Auth::user()->is_banned) 
                <button id="edit-status-btn">Edit</button>
            @endif
        </nav>
        
        <table class="users-table">
            <thead>
                <tr>
                    <th></th> <th>Username</th>
                    <th>Name</th> <th>Email Address</th>
                    <th>Rank</th> <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <x-userinfo :user="$user"/>               
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </section>
@endsection