@extends('layouts.layout')

@section('content')

<div class='mt100'>
    <div>
        <table>
            @if($results)
                @foreach($results as $result)
                <tr>
                    <td class='tweet_detailname'>{{$result['user']['name']}}</td>
                    <td class='tweet_detailth'>{{$result['tweet']}}</td>
                    <td><button type="button" class="good_btn <?php if($result['good']){ echo "font_red"; } ?>" id='good' data-user-id=<?= Auth::user()->id ?> data-tweet-id="{{$result['id']}}"><i>&hearts;</i></button></td>                    
                </tr>
                @endforeach
            @endif
        </table>
        <form action="{{route('back_page')}}" method="POST">
            @csrf
            <button class='back_btn' type="submit" name="back_page" value="good">戻る</button>
        </form>
    </div>
</div>

@endsection