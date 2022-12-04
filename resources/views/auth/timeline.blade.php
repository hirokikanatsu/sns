@extends('layouts.layout')

@section('content')
    @if(session('f_msg'))
        <div class='f_msg' id='msg'>{{session('f_msg')}}</div>
    @endif
    <div class='cursor' id='timeline_space'>
        @if($tweets != 'ツイートがありません')
            @include('tweet_list');
            <input type='hidden' value=10 id='count'>
            <div class='t_center mb50' id='no_tweet' style="display:none">表示するツイートがありません</div>
        @else
        <h1 class='t_center mt100'>フォローしているユーザーのツイートがありません</h1>
        @endif
    </div>
        <button class='tweet_create_btn fix_bottom'><a href="{{route('timeline')}}">ツイートする</a></button>
        

<script>
 // *******************考え直し*************************
//  ツイート後のセッションメッセージ出力
    // let f_msg = "{{ Session::get('f_msg') }}";
    // let msg = document.getElementById('msg');
    // if(sessionStorage.getItem('f_msg') == "1"){
    //     msg.classList.add('no_action');
    // }

    // console.log(f_msg);
    // console.log(sessionStorage.getItem('f_msg'));

    // //ツイート後のsessionデータ確認
    // if(f_msg != ''){
    //     sessionStorage.f_msg = f_msg;
    // }

	// if (sessionStorage.f_msg) {
	// 	if (sessionStorage.getItem('f_msg') != "1") {
    //         if(msg.classList.contains('no_action')){
    //             msg.classList.toggle('no_action');
    //             sessionStorage.removeItem('f_msg');
	// 		    sessionStorage.setItem('f_msg', "1");
    //         }     
	// 	}
	// }
</script>
@endsection