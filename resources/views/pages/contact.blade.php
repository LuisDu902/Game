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
            <li> Contact us</li>
        </ul>
    </div>
   
    <section class="contact-section">
        
        <h1>Contact us</h1>
        <div class="contact-wrapper">
            <div>
                <p>Let’s talk about your website or project.
                    Send us a message and we will be in touch within two business days.</p>
                <img src="{{ asset('images/contact.png') }}" alt="contact-image">
            </div>
            
            <form id="contactForm" method="POST">
                {{ csrf_field() }}
                <div class="contact-input contact-name">
                    <label class="field-label" for="name"> Name <span
                            class="purple">*</span> </label>
                    <input id="contact-name" type="text" name="name" placeholder="your name"
                        required>
                </div>
    
                <div class="contact-input contact-email">
                    <label class="field-label" for="email"> Email Address
                        <span class="purple">*</span> </label>
                    <input id="profile-email" type="email" name="email"
                        placeholder="email@example.com" required>
                </div>
                <div class="contact-input contact-description">
                    <label class="field-label" for="description">
                        Message </label>
                        <textarea id="profile-description" name="description" placeholder="Your description"></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
        

    </section>
@endsection
