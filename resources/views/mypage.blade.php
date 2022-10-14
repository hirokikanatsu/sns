
@extends('layouts.layout')

@section('content')
    @if(session('f_msg'))
        <div class='f_msg' id='msg'>{{session('f_msg')}}</div>
    @endif

<button id='myprofile'><a href="{{route('myprofile')}}">プロフィール</a></button>
<div class='mt100'>
    <div>
        <table>
            @if($tweets)
                @foreach($tweets as $key => $tweet)
                <tr>
                    <td class='tweet_detailth'>{{$key+1}}</td>
                    <td class='tweet_detailtd'>{{$tweet['tweet']}}</td>
                    <td><button class='edit_btn'><a href="{{route('tweet_edit',['id'=>$tweet['id']])}}" class='block'>編集</a></button></td>
                    <td><button class='delete_btn'><a href="{{route('delete_tweet',['id'=>$tweet['id']])}}">削除</a></button></td>
                </tr>
                @endforeach
            @else
                <h1 class='ml100'>{{Auth::user()->name}}さんのツイートがありません</h1>
            @endif
        </table>
        <form action="{{route('back_page')}}" method="POST">
            @csrf
            <button class='back_btn' type="submit" name="back_page" value="timeline">戻る</button>
        </form>
    </div>
</div>

@endsection
