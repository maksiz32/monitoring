<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') . '?v=' . uniqid('', true) }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0 m-0">
        <div class="container-fluid">
            <a class="navbar-brand navbar-brand__logo" href="/">
                <img src="{{asset('img/logo/logo.png')}}" alt="" height="40px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="text-right">
                @guest
                    @if (Route::has('login'))
                        <div class="nav-item pull-right">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                        </div>
                    @endif
                @else
                    <div class="collapse navbar-collapse pull-right" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-lg-end"
                                    aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Создать подразделение</a></li>
                                    <li><a class="dropdown-item" href="{{ route('printer.new') }}">Создать принтер</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Создать удалённое управление</a></li>
                                    <li><a class="dropdown-item" href="{{ route('contract.new') }}">Создать договор</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('point.view-import-xls') }}">Загрузить данные</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('contract.list') }}">Договоры</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('printer.list') }}">Принтеры</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Удаленные подключения</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Выход') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <div class="py-4">
        @yield('content')
    </div>
</div>
</body>
</html>
