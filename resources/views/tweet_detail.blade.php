@extends('layouts.layout')

@section('content')

<div class='mt100'>
    <div>
        <table>
            @if($results)
                @foreach($results as $result)
                <tr>
                    <td class='tweet_detailth'>{{$result['user']['name']}}</td>
                    <td class='tweet_detailtd'>{{$result['tweet']}}</td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>

@endsection