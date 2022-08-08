@extends('layouts.layout')

@section('content')
<div class='form_wrapper'>
    <form action="{{route('edit_conf',['id' => $results[0]['id']])}}" method="post">
        @csrf
        <div id='tweet_form'>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <li class='font_red err_msg'>{{ $error }}</li>
                @endforeach
            @endif
            <input type="text" name="tweet" id='tweet_formbox' value="<?php if($results){echo $results[0]['tweet'];}?>">
            <input type="hidden" name='id' value="{{$results[0]['id']}}">
            
            <button type="submit" class='tweet_create_btn'>ツイート</button>
        </div>
    </form>
    <form action="{{route('back_page')}}" method="POST">
        @csrf
        <button class='back_btn' type="submit" name="back_page" value="mypage">戻る</button>
    </form>
</div>
@endsection