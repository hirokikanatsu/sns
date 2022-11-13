<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TweetCountMail;


use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use App\Models\Good;

class MailController extends Controller
{
    public function send(Request $request)
    {
        $name = 'テスト ユーザー';
        $email = 'test@example.com';

        Mail::send(new TweetCountMail($name, $email));


        //テスト用のトップページ遷移のためのデータ取得
        // $this->good = new Good;
        
        // $tweets = Tweet::followingTweets()->paginate(10);

        // if($tweets == []){
        //     $tweets = 'ツイートがありません';
        // }else{
        //     foreach($tweets as $key => $tweet){
        //         $result = $this->good->where('tweet_id',$tweet['id'])->where('user_id',Auth::user()->id)->get()->toArray();

        //         if($result){
        //             $tweets[$key]['good'] = true;
        //         }else{
        //             $tweets[$key]['good'] = false;
        //         }
        //     }
        // }

        // return view('Auth.timeline',['tweets' => $tweets]);
    }
}
