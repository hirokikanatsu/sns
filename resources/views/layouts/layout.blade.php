<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/base.css') }}" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Laravel</title>

    </head>

    <body>

    <div id='header_wrapper' class="t_center">
        <div>
            <img id='myicon' class='ml20' src="{{ asset('img/tibetto.jpg') }}" alt="チベットスナギツネの写真">
            <img id='icon' class='ml20' src="{{ asset('img/tibetto.jpg') }}" alt="チベットスナギツネの写真">
        </div>

    </div>

    @yield('content')


    <div id='footer_wrapper' class="t_center"></div>
    </body>
</html>

