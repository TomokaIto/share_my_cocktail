<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>

<body class="" style="background-image: url('/storage/images/bar2.jpg');
  background-position: center center;
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm w-100" style="position: sticky ; top: 0; left: 0; z-index: 99; background-color: rgba(128, 128, 128, 0.662);">
            <div class="container">
                <a class="navbar-brand text-light" href="{{ url('/') }}">
                    {{ __('Share my Cocktail') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <!-- <ul class="navbar-nav ms-auto"> -->
                        <!-- Authentication Links -->
                        <!-- @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link btn-secondary text-light" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-secondary btn-light" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                        </li>
                        @endif
                        @else -->
                        <!-- <li class="nav-item dropdown"> -->
                        <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle btn-secondary text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a> -->

                        <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"> -->
                        <!-- <a class="nav-link text-secondary btn-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('ログアウト') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form> -->
                        <!-- </div> -->
                        <!-- </li> -->
                        <!-- @endguest
                    </ul> -->

                    <div class="dropdown">
                        <!-- 切替ボタンの設定 -->
                        <button type="button" class="btn btn-dark dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(auth()->user())
                            {{ Auth::user()->name }}
                        @else
                            MENU
                        @endif
                        </button>
                        <!-- ドロップメニューの設定 -->
                        <div class="dropdown-menu " aria-labelledby="dropdownMenuButton2">
                            @if(auth()->user())
                            <a class="dropdown-item" href="/cocktailMylist" role="button">投稿一覧</a>
                            <a class="dropdown-item" href="/cocktailCreate" role="button">新規投稿</a>
                            <a class="dropdown-item" href="/cocktailMyfavorite" role="button">お気に入り一覧</a>
                            @if(Auth::user()->role === 0)
                            <a class="dropdown-item" href="/userIndex" role="button">ユーザ一覧</a>
                            @endif
                            @endif
                            
                            @guest
                            @if (Route::has('login'))
                            <a class="dropdown-item" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            @if (Route::has('register'))
                            <a class="dropdown-item" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                            @endif
                            @else
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('ログアウト') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-4 bg-secondary text-white " style="background-image: url('/storage/images/bar2.jpg');
                        background-position: center center;
                        background-repeat: no-repeat;
                        background-size: cover;
                        background-attachment: fixed;
                        ">
            @yield('content')
        </main>
    </div>
</body>

</html>