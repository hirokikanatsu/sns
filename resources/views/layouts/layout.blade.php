<?php

use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/base.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}"></script>
        <!-- <script src=“https://js.pusher.com/3.2/pusher.min.js“></script>
        <script src=“https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js”></script> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <title>Laravel</title>

    </head>

    <body>
    <div id='header_wrapper' class="t_center">
        <div>
            @if(session('new_image') != null)
                <img id='myicon' src="{{ asset('storage/'<?php echo session('new_image')[0]?>) }}" />
            @elseif(!empty(Auth::user()->image))
                <img id='myicon' src="{{ asset('storage/'. Auth::user()->image) }}" />
            @else
                <img id='myicon' src="{{ asset('img/noimage.png') }}" />
            @endif
            <img id='icon' class='ml20' src="{{ asset('img/tibetto.jpg') }}" alt="チベットスナギツネの写真">
            <div id='myname'>{{Auth::user()->name}}</div>
            <button id='search_users'><a href="{{route('search_users_form')}}">ユーザー検索</a></button>
            <button id='mypage'><a href="{{route('mypage')}}">マイページ</a></button>
            <form action="{{route('logout')}}" method='post'>
                @csrf
                <button id='logout'>ログアウト</button>
            </form>
        </div>

    </div>

    @yield('content')

    <script src="{{ asset('/js/base.js') }}"></script>