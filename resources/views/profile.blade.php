@extends('layouts.layout')

@section('content')
    @if(session('f_msg'))
        <div class='f_msg' id='msg'>{{session('f_msg')}}</div>
    @endif

<div class='mt100'>
    <div>
        <table>
            @if($tweets)
                <h1 class='t_center user_name'>{{$tweets[0]['user']['name']}}</h1>
                <button type="button" class="follow_btn" id='follow' data-follower_id=<?= Auth::user()->id ?> data-follow_id="{{$tweets[0]['user']['id']}}">{{$is_follow}}</button>
                @foreach($tweets as $key => $tweet)
                <tr>
                    <td class='tweet_detailth'>{{$key + 1}}</td>
                    <td class='tweet_detailtd'><a href="{{route('tweet.detail',['id' =>$tweet['id']])}}">{{$tweet['tweet']}}</a></td>
                </tr>
                @endforeach
            @else
                <h1 class='t_center'>{{Auth::user()->name}}さんのツイートがありません</h1>
            @endif
        </table>
        <form action="{{route('back_page')}}" method="POST">
            @csrf
            <button class='back_btn' type="submit" name="back_page" value="timeline">戻る</button>
        </form>
    </div>
</div>

@endsection