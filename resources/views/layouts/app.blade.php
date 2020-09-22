<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('page_title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/perso.css') }}">

        {{-- @livewireStyles --}}

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        @if (Route::has('login'))
        <ul class="nav">


                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <li><a href="{{ url('/dashboard') }}" >Dashboard</a></li>

                    @else
                        <li><a href="{{ route('login') }}" >Login</a></li>

                        @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" >Register</a></li>
                        @endif
                    @endif
                    <a href="/">Home bro</a>
                </div>
                @endif
        </ul>
        <div class="min-h-screen bg-gray-100">
            {{-- @livewire('navigation-dropdown') --}}

            <!-- Page Heading -->
            <header>
                <div class="header-bloc">
                    <div class="header perso-titles">
                        <h1>@yield('page_title')</h1>
                    </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="container">
                @yield('content')
                </div>
            </main>
        </div>

        {{-- @stack('modals') --}}

        {{-- @livewireScripts --}}
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>
