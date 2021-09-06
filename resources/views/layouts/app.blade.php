<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'fyrestream') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- CSRF Token -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('favicon/safari-pinned-tab.svg')}}" color="#5bbad5">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 1.5;
            position: relative;
        }

        /* Footer CSS */

        #footer {
            background: #161616;
            padding-top: 60px;
            padding-bottom: 40px;
            color: #939393;
        }

        .ft-space {
            display: block;
            width: 100%;
            height: 1px;
            background: #ccc;
            margin-bottom: 20px;
        }

        .footer-box {
            margin-bottom: 30px;
        }

        .footer-box h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #fff;
        }

        .footer-box ul li a {
            display: inline-block;
            width: 100%;
            padding: 5px 0;
            font-weight: 400;
            color: #939393;
        }

        .footer-box ul li a:hover {
            color: #0dcaf0;
        }

        .footer-box ul li span {
            display: block;
            margin-bottom: 10px;
            color: #666;
        }

        .newsletter {}

        .newsletter .form-dp {
            width: 60%;
            float: left;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .newsletter .btn-dp {
            width: 35%;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            padding: 12px 10px;
        }

        .copyright p {
            margin: 0;
            padding: 5px 0;
        }

        .social-link li {
            display: inline-block;
        }

        .social-link li a {
            color: #939393;
            font-size: 20px;
            padding: 5px 8px;
        }

        .social-link li a:hover {
            color: #0dcaf0;
        }

        .card-link {
            padding: 5px 0;
        }

        /* Profile top image */
        .navbar .avatar {
            margin-top: -15px;
            margin-bottom: -15px;
        }

        .profile-top-image {
            object-fit: cover;
            border-radius: 50% !important;
            box-shadow: 1px 1px 5px 0 #00bbd444,
                -1px 1px 5px 0 #4caf4f54,
                1px -1px 5px 0 #7c00d446,
                -1px -1px 5px 0 #af6f4c4d;
        }

        .avatar {
            width: 40px;
            height: 40px;
        }

    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if(Auth::user()->image)
                                <img src=" {{Auth::user()->image}} " class="avatar img-fluid d-none d-sm-inline-block profile-top-image me-1" alt=" {{Auth::user()->name}} " />
                                @elseif(Auth::user()->gender === "male")
                                <img src=" {{asset('storage/images/static/blank_profile_male.jpg')}} " class="avatar img-fluid d-none d-sm-inline-block profile-top-image me-1" alt=" {{Auth::user()->name}} " />
                                @elseif(Auth::user()->gender === "female")
                                <img src=" {{asset('storage/images/static/blank_profile_female.jpg')}} " class="avatar img-fluid d-none d-sm-inline-block profile-top-image me-1" alt=" {{Auth::user()->name}} " />
                                @else
                                <img src=" {{asset('storage/images/static/default_profile.jpg')}} " class="avatar img-fluid d-none d-sm-inline-block profile-top-image me-1" alt=" {{Auth::user()->name}} " />
                                @endif
                                <span>{{ Auth::user()->name }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="/profile" class="dropdown-item">Profile</a>
                                <span class="dropdown-divider"></span>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if (session('status'))
        <div class="alert alert-success mt-2 text-center" role="alert">
            {{ session('status') }}
        </div>
        @endif
        @if (session('message'))
        <div class="alert alert-success mt-2 text-center" role="alert">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger mt-2 text-center" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function getCookie(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(";");
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    let posOf = c.indexOf(name, 0);
                    if (posOf != -1) {
                        return c.substr(posOf + name.length);
                    }
                }
                return null;
            }

        </script>
        @stack('scripts')
    </div>
</body>
</html>
