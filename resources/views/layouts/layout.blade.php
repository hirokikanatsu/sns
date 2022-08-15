<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/base.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Laravel</title>

    </head>

    <body>

    <div id='header_wrapper' class="t_center">
        <div>
            <img id='myicon' class='ml20' src="{{ asset('img/tibetto.jpg') }}" alt="チベットスナギツネの写真">
            <img id='icon' class='ml20' src="{{ asset('img/tibetto.jpg') }}" alt="チベットスナギツネの写真">
            <button id='mypage'><a href="{{route('mypage')}}">マイページ</a></button>
            <form action="{{route('logout')}}" method='post'>
                @csrf
                <button id='logout'>ログアウト</button>
            </form>
        </div>

    </div>

    @yield('content')

    <script src="{{ asset('/js/base.js') }}"></script>