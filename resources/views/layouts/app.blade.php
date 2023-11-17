<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
<<<<<<< Updated upstream
=======
        <link href="{{ url('css/navbar.css') }}" rel="stylesheet">
        <link href="{{ url('css/auth.css') }}" rel="stylesheet">
        <link href="{{ url('css/footer.css') }}" rel="stylesheet">
        <link href="{{ url('css/sidebar.css') }}" rel="stylesheet">
        <link href="{{ url('css/breadcrumb.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/questions.css') }}" rel="stylesheet">
        <link href="{{ url('css/pagination.css') }}" rel="stylesheet">
        <link href="{{ url('css/admin.css') }}" rel="stylesheet">
        <link href="{{ url('css/category.css') }}" rel="stylesheet">
        <link href="{{ url('css/game.css') }}" rel="stylesheet">

>>>>>>> Stashed changes
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
<<<<<<< Updated upstream
        <main>
            <header>
                <h1><a href="{{ url('/cards') }}">Thingy!</a></h1>
                @if (Auth::check())
                    <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
                @endif
            </header>
            <section id="content">
=======
        @if(in_array(request()->route()->getName(), ['login', 'register']))
            @yield('authentication')
        @else
            @include('partials._header')
            @if(in_array(request()->route()->getName(), ['category', 'game']))
            <div class="purple-section"></div>
            @endif
            <main>
>>>>>>> Stashed changes
                @yield('content')
            </section>
        </main>
    </body>
</html>