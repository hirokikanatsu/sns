@extends('layouts.layout')

@section('content')
    @if(session('f_msg'))
        <div class='f_msg' id='msg'>{{session('f_msg')}}</div>
    @endif
    
    <div>
        @if($tweets)
        <table class='tweet_area'>
            @foreach($tweets as $tweet)
            <div class='tweet_space'>
                <tr>
                    <th class='tweet_th'>{{$tweet['user']['name']}}</th>
                    <td class='tweet_td'><a href="{{route('tweet.detail',['id' =>$tweet['id']])}}">{{$tweet['tweet']}}</a></td>
                </tr>
            </div>
            @endforeach
        </table>
        @endif
    </div>
        <button class='tweet_create_btn fix_bottom'><a href="{{route('timeline')}}">ツイートする</a></button>
        <script src="{{ mix('js/app.js') }}"></script>

<script>
    // *******************考え直し*************************
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