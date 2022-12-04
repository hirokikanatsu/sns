@extends('layouts.layout')

@section('content')

<div id='search_form'>
    <form action="{{route('search_users')}}" method="POST" id='search_form_submit'>
        @csrf
        <input type="text" name="user_name" placeholder="ユーザー名を入力">
        <button id='search_user'>検索</button>
    </form>
</div>
<button><a href="{{route('auth/login/twitter')}}">ツイッターログイン</a></button>
<div id='searched_users' class="t_center">
    @if(isset($user_name) && ($user_name != ''))
    <h1>ユーザー検索結果</h1>
        <ul>
            @foreach($user_name as $user)
            <div class='user_info'>
                <li id='search_user_name'>{{ $user['name'] }}</li>
                <li id='search_user_id'><a href="{{ route( 'user_profile',[ 'id'=> $user['id'] ] ) }}">ユーザープロフィールを表示</a></li>
            </div>
            @endforeach
        </ul>
    @endif
</div>
<form action="{{route('back_page')}}" method="POST">
    @csrf
    <button class='back_btn_to_top' type="submit" name="back_page" value="timeline">タイムラインへ戻る</button>
</form>

@endsection