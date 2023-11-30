<header>
    <nav class="navbar">
        <a class="logo" href="{{ route('home') }}">
            <img src="{{ asset('images/white_logo.png') }}" alt="logo">
            <strong>GameOn</strong>
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('questions') }}">Questions</a></li>
            <li><a href="{{ route('categories') }}">Game
                    Categories</a></li>
        </ul>

        <form class="search-box" method="POST" action="{{ route('questions') }}">
            @csrf
            <input type="text" id="search-input" name="query"
                placeholder="Search for posts...">
            <button type="submit" id="search-button" >
                <ion-icon name="search"></ion-icon>
            </button>
        </form>

        @if (Auth::check())
        <div class="left">
            <a href="{{ route('users') }}" class="admin">
                Admin Section
            </a>
            <div class="dropdown">
                
                <div class="user">
                    <img src="{{ Auth::user()->getProfileImage() }}" alt="user-profile">
                    <strong class="username white"> {{ Auth::user()->username }} </strong>
                    <button class="dropbtn white">
                        <ion-icon name="chevron-down"></ion-icon>
                    </button>
                </div>
                <div class="dropdown-content">
                    <a href="{{ route('profile', ['id' => Auth::user()->id]) }}">Profile</a>
                    <a href="{{ route('users_questions', ['id' => Auth::user()->id]) }}">My Questions</a>
                    <a href="{{ route('users_answers', ['id' => Auth::user()->id]) }}">My Answers</a>
                    <a href="{{ url('/logout') }}">Sign out</a>
                </div>
            </div>
        </div>
        @else
            <div class="buttons">
                <a href="{{ route('register') }}">
                    <button class="sign-up-btn">Sign Up</button></a>
                <a href="{{ route('login') }}">
                    <button class="sign-in-btn">Sign In</button></a>
            </div>
        @endif
        

    </nav>
</header>



              