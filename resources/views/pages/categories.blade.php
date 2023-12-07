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
            <li >Game Categories</li>
        </ul>
   </div>

   <div class="categories-section">
        <h1>Game Categories</h1>
        <section class="categories-grid">
            @foreach($categories as $category)
                <a href="{{ route('category', ['id' => $category->id]) }}" class="category-card">
                    <h2><span class="purple">{{ $category->name }}</span> games</h2>
                    <p>{{ $category->description }}</p>
                </a>
            @endforeach
        </section>
    </div>
@endsection