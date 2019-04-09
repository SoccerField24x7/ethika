<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ethika Code Challenge</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <img src="{{ asset('images/ethika.png') }}" alt="Ethika logo" width="750" />
                </div>

                <div class="links">
                    <a href="/order">New Order</a>
                    <a href="/search">Search Orders</a>
                    <a href="https://www.linkedin.com/in/jesse-quijano/">LinkedIn</a>
                    <a href="https://github.com/SoccerField24x7">GitHub</a>
                    <a href="https://stackoverflow.com/users/1732853/jesse-q">Stack Overflow</a>
                    <a href="https://exercism.io/profiles/CodeNja">Exercism.io</a>
                </div>
            </div>
        </div>
    </body>
</html>
