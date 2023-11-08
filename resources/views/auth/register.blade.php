@extends('layouts.app')

@section('authentication')

<div class="limiter"> 
    <div class="auth-container"> 
        <form method="POST" action="{{ route('register') }}" class="auth-form">
  
            @csrf

            <h1>User Register</h1>

            <label for="name">Name</label>
            <div class="input-wrapper"> 
                <ion-icon class="icon" name="person"></ion-icon> 
                <input class="input" type="text" name="name" placeholder="Full name" value="{{ old('name') }}" required> 
            </div> 

            @if ($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span>
            @endif

            <label for="username">Username</label>
            <div class="input-wrapper field"> 
                <ion-icon class="icon" name="person"></ion-icon> 
                <input class="input" type="text" name="username" placeholder="Username" value="{{ old('username') }}" required> 
            </div> 

            @if ($errors->has('username'))
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
            @endif
            
            <label for="email">Email</label>
            <div class="input-wrapper field">
                <ion-icon class="icon" name="mail"></ion-icon> 
                <input class="input" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <label for="password">Password</label>
            <div class="input-wrapper field"> 
                <ion-icon class="icon" name="lock-closed"></ion-icon>
                <input class="input" type="password" name="password" placeholder="Password" required> 
            </div>

            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif

            <label for="password-confirm">Confirm Password</label>
            <div class="input-wrapper field"> 
                <ion-icon class="icon" name="lock-closed"></ion-icon> 
                <input class="input" type="password" name="password_confirmation" placeholder="Confirm password" required>
            </div> 
            
            <div class="btn-wrapper reg-btn">
                <button type="submit" class="register-btn"> Register </button>
            </div>

            <div class="toggle-register">
                <span> Already registered?
                    <a href="{{ route('login') }}" class="toggle-register"> Login </a>
                </span>
            </div> 
        </form>
    </div> 
</div>

@endsection