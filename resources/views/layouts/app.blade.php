<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($pageTitle) ? $pageTitle : config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    @stack('header')
</head>

<body>
    <div id="app" class="rtl">
        <header class="main-header js-main-header">
            <div class="container container--lg">
                <div class="main-header__layout">
                    <div class="main-header__logo">
                        <a href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <button class="btn btn--subtle main-header__nav-trigger js-main-header__nav-trigger" aria-label="Toggle menu" aria-expanded="false" aria-controls="main-header-nav">
                        <i class="main-header__nav-trigger-icon" aria-hidden="true"></i>
                        <span>Menu</span>
                    </button>
                    <nav class="main-header__nav js-main-header__nav" id="main-header-nav" aria-labelledby="main-header-nav-label" role="navigation">
                        <div id="main-header-nav-label" class="main-header__nav-label">Main menu</div>
                        <ul class="main-header__nav-list">
                            @guest
                            <li class="main-header__nav-item">
                                <a class="main-header__nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="main-header__nav-item">
                                <a class="main-header__nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="main-header__nav-item"><a href="{{ route('panel-dashboard') }}" class="main-header__nav-link" @if(Request::is('panel/dashboard')) aria-current="page" @endif>{{ __('Dashboard') }}</a></li>
                            <li class="main-header__nav-item"><a href="{{ route('panel-channels') }}" class="main-header__nav-link" @if(Request::is('panel/channels')) aria-current="page" @endif>{{ __('Channels') }}</a></li>
                            <li class="main-header__nav-item"><a href="{{ route('panel-keywords') }}" class="main-header__nav-link" @if(Request::is('panel/keywords')) aria-current="page" @endif>{{ __('Keywords') }}</a></li>
                            <li class="main-header__nav-item main-header__nav-divider" aria-hidden="true"></li>
                            <li class="main-header__nav-item">
                                <nav class="dropdown js-dropdown">
                                    <ul>
                                        <li class="dropdown__wrapper">
                                            <a href="javascript:" class="dropdown__trigger icon-text icon-text--gap-xxxxs">
                                                <span>{{ auth()->user()->name }}</span>
                                                <svg aria-hidden="true" class="icon" viewBox="0 0 16 16">
                                                    <polyline fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="3.5,6.5 8,11 12.5,6.5 "></polyline>
                                                </svg>
                                            </a>
                                            <ul class="dropdown__menu" aria-label="submenu">
                                                <li>
                                                    <a class="dropdown__item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </li>
                            @endguest
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    @stack('footer')
</body>

</html>
