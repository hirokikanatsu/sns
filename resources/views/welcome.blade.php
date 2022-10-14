<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/base.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Laravel</title>

    </head>
    <body class="antialiased">

        <div class='head_wrapper' id='wrapper'>
            <div class='ml100'>
                <h1 class='mt50' id='top_title'>SNS(仮)</h1>
                <p id='login_logo'>ログイン・新規登録</p>
                <!-- <a href="{{route('login')}}" id='login_logo'>ログイン・新規登録</a> -->
            </div>  

            <div id='top_wrapper'>
                <h1 class='ml100 pt100' id='top_h1'>飲食のためのSNS</h1>
            </div>
            
        </div>
        @include('auth.login_modal');
    </body>
    <script src="{{ asset('js/base.js') }}"></script>

</html>
