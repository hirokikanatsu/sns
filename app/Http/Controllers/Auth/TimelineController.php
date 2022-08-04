<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Models\Tweet;

class TimelineController extends Controller
{
    public function showTimelinePage()
    {
        return view('Auth.timeline'); 
    }

    public function formTimeline(){
        return view('form_timeline');
    }

    public function postTweet(TweetRequest $request) 
    {
        
        $tweet = new Tweet;
        // dd(Auth::user());
        $tweet->user_id = Auth::user()->id;
        $tweet->tweet = $request->tweet;
        
        $tweet->save();
        return view('home');
    }
}
