@extends('layouts.app')

@section('authentication')

<div class="limiter">
    <div class="auth-container">
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            
            @csrf

            <h1> User Login </h1>

            <label for="email">Email</label>
            <div class="input-wrapper">
                <ion-icon class="icon" name="person"></ion-icon>
                <input id="email" class="input" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
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

            <div class="extra">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>

            <div class="btn-wrapper">
                <a href><button class="login-btn"> Login </button></a>
            </div>

          
            <div class="toggle-login">
                <span> Don't have an account?
                    <a href="{{ route('register') }}" class="toggle-register">Register </a>
                </span>
            </div>

        </form>
    </div>
</div>

@endsection