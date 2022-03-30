<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@include('js-localization::head')
<div id="app">
    @yield('js-localization.head')
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="{{route('home')}}">
            <img class="logo" src="{{asset('logo.png')}}" alt="logo">
        </a>
        <ul class="list-group flex-row align-items-center">
            <span class="mr-2">Сменить язык на </span> <li class="list-group-item"><a href="{{route('locale',app()->getLocale()==='ru'?'kz': 'ru')}}">{{app()->getLocale()==='ru'?'kz': 'ru'}}</a></li>
        </ul>
    </nav>
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<script>
    $('#phone').inputmask('+7-(999)-999-9999');
</script>
</body>
</html>
