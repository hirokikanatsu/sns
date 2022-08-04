@extends('layouts.layout')

@section('content')
        <button class='tweet_create_btn fix_bottom'><a href="{{route('timeline')}}">ツイートする</a></button>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
@endsection