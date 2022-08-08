@extends('layouts.layout')

@section('content')
    @if(session('f_msg'))
        <div class='f_msg' id='msg'>{{session('f_msg')}}</div>
    @endif

<div class='mt100'>
    <div>
        <table>
            @if($results)
                @foreach($results as $result)
                <tr>
                    <td class='tweet_detailth'>{{$result['id']}}</td>
                    <td class='tweet_detailtd'>{{$result['tweet']}}</td>
                    <td><button class='edit_btn'><a href="{{route('tweet_edit',['id'=>$result['id']])}}" class='block'>編集</a></button><td>
                    <td><button class='delete_btn' onclick=click()>削除</button><td>
                </tr>
                @endforeach
            @endif
        </table>
        <form action="{{route('back_page')}}" method="POST">
            @csrf
            <button class='back_btn' type="submit" name="back_page" value="timeline">戻る</button>
        </form>
    </div>
</div>

@endsection
