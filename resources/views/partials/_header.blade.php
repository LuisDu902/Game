<header>
    <nav class="navbar">
        <a class="logo" href="home.html">
            <img src="{{ asset('images/white_logo.png') }}" alt="logo">
            <strong>GameOn</strong>
        </a>
        <ul class="nav-links">
            <li class="about-us"><a href="common/faq.html">Questions</a></li>
            <li class="FAQ"><a href="common/faq.html">Users</a></li>
            <li class="contact"><a href="common/contact.html">Game
                    Categories</a></li>
        </ul>

        <form class="search-box">
            <input type="text" id="search-input" name="query"
                placeholder="Search for posts...">
            <button type="submit" id="search-button">
                <ion-icon name="search"></ion-icon>
            </button>
        </form>

        @if (Auth::check())
            <div class="dropdown">
                <div class="user">
                    <img src="{{ asset('images/user.png') }}" alt="user-profile">
                    <strong class="username white"> Gengar </strong>
                    <button class="dropbtn white">
                        <ion-icon name="chevron-down"></ion-icon>
                    </button>
                </div>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">My posts</a>
                    <a href="{{ url('/logout') }}">Sign out</a>
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



              