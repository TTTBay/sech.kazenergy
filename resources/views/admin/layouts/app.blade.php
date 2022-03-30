<!doctype html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kazenergy') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@include('js-localization::head')
<div id="app">
    @yield('js-localization.head')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="">
            <img class="logo" src="{{asset('logo.png')}}" alt="logo">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link @if(\request()->segment(2)==='university') active @endif" href="{{route('admin.university')}}">ВУЗ</a>
                <a class="nav-item nav-link @if(\request()->segment(2)==='college') active @endif" href="{{route('admin.college')}}">Колледж</a>
            </div>
        </div>
        <form action="{{route('admin.logout')}}" method="POST">
            @csrf
            <button class="btn btn-info">Выйти</button>
        </form>
    </nav>
    <main class="py-4">
        <div class="container">
            @include('.partials.alerts')
            @yield('content')
        </div>
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('admin-js/app-admin.js') }}" defer></script>

</body>
</html>
