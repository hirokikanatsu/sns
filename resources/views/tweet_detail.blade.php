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
                    <?php if($result['file_name']): ?>
                        @if(pathinfo($result['file_name'], PATHINFO_EXTENSION) == 'mov' || pathinfo($result['file_name'], PATHINFO_EXTENSION) == 'mp4')
                            <td class='tweet_detailth' id='movie'><video controls muted><source src="{{ asset('storage/'. $result['file_name']) }}" type="video/mp4"></video></td>
                        @elseif($result['file_name'] != '')
                            <td class='tweet_detailth' id='image'><img src="{{ asset('storage/'.$result['file_name']) }}"></td>
                        @endif
                    <?php endif; ?>
                    <td><button type="button" class="detail_good_btn <?php if($result['good']){ echo "font_red"; } ?>" id='good' data-user-id=<?= Auth::user()->id ?> data-tweet-id="{{$result['id']}}"><i>&hearts;</i></button></td>                    
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