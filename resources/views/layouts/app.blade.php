<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div id="app">

        
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent">

                    <span class="navbar-toggler-icon"></span>

                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto">
                    </ul>


                    <ul class="navbar-nav ms-auto">

                        @guest

                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                </li>
                            @endif

                        @else

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown"
                                   class="nav-link dropdown-toggle"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown">

                                    {{ Auth::user()->name }}

                                </a>


                                <div class="dropdown-menu dropdown-menu-end">

                                    <a class="dropdown-item"
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">

                                        {{ __('Logout') }}

                                    </a>


                                    <form id="logout-form"
                                          action="/logout"
                                          method="POST"
                                          class="d-none">

                                        @csrf

                                    </form>

                                </div>

                            </li>

                        @endguest

                    </ul>

                </div>

            </div>

        </nav>


       
        <div class="container-fluid">

            <div class="row">

                
                <div class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-0">

                    <div class="p-3">
                        <h4>Admin Menu</h4>
                    </div>


                    <div class="list-group list-group-flush">

                        <a href="{{ route('company.index') }}"
                           class="list-group-item list-group-item-action bg-dark text-white">

                            Company

                        </a>


                        <a href="{{ route('employee.index') }}"
                           class="list-group-item list-group-item-action bg-dark text-white">

                            Employee

                        </a>

                    </div>

                </div>


              
                <div class="col-md-9 col-lg-10 p-4">

                    @yield('content')

                </div>

            </div>

        </div>

    </div>

</body>

</html>