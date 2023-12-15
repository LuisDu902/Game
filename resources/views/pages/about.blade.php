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
            <li> About us</li>
        </ul>
    </div>
   
    <section class="about-section">
        <h1>About us</h1>
        <div class="about-us">
            <h2>We are a team of professional people who loves what they do</h2>
            <p>Lorem Ipsum is een the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more  Lorem Ipsum.</p>
        </div>
        <div class="team">
            <h1>Meet our team</h1>
            <ul>
                <li>
                    <img src="{{ asset('images/member1.png')}}" alt="member1">
                    <span>Ana Sofia Azevedo</span>
                </li>
                <li>
                    <img src="{{ asset('images/member2.png')}}" alt="member2">
                    <span>Catarina Isabel Canelas</span>
                </li>
                <li>
                    <img src="{{ asset('images/member3.png')}}" alt="member3">
                    <span>Gabriel Ferreira</span>
                </li>
                <li>
                    <img src="{{ asset('images/member4.png')}}" alt="member4">
                    <span>Luís Du</span>
                </li>
            </ul>
      </div>
    </section>
@endsection
