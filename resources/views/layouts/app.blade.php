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
    </body>
</html>
