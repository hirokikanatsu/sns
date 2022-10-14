<table class='tweet_area' id='tweet_content'>
        @foreach($tweets as $key => $tweet)
            <tr>
                <th class='tweet_th'><a href="{{route('profile',['id' =>$tweet['user']['id']])}}" class='detail_user'>{{$tweet['user']['name']}}</a></th>
                <td class='tweet_td'><a href="{{route('tweet.detail',['id' =>$tweet['id']])}}" class='detail_tweet'>{{$tweet['tweet']}}</a></td>
                <td id='goods'><button type="button" class="good_btn good <?php if($tweet['good']){ echo "font_red"; } ?>" id='good'  data-user-id=<?= Auth::user()->id ?> data-tweet-id="{{$tweet['id']}}"><i>&hearts;</i></button></td>
            </tr>   
        @endforeach
</table>