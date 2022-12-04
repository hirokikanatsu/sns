@extends('layouts.layout')



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        </div>
    </div>
 
    {{--  チャットルーム  --}}
    <div id="room">
        @if(isset($messages) && $messages != '')
        @foreach($messages as $key => $message)
            {{--   送信したメッセージ  --}}
            @if($message->send_user_id == Auth::id())
                <div class="send" style="text-align: right">
                    <p>{{$message->contents}}</p>
                </div>
            @else
                <div class="receive" style="text-align: left">
                    <p>{{$message->contents}}</p>
                </div>
            @endif
        @endforeach
        @endif
    </div>
 
    <form style="width:90%;">
        <textarea name="message" id="contents" style="width:100%;" ></textarea>
        <button type="button" id="chat_btn_send" style="width:100px;">送信</button>
    </form>
    <!-- <div style="font-size: 100px;">
        <p>{{Auth::user()->name}}</p>
    </div> -->

    <input type="hidden" name="receive_id" id="receive_id" value="{{$id}}">
    <input type="hidden" name="send_id" id="send_id" value="{{Auth::id()}}">
 
</div>
@endsection