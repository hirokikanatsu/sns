<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class TimelineController extends Controller
{
    public function loginConfirm(LoginRequest $request)
    {
        
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return view('Auth.timeline');
        }

        return back()->withErrors([
            'login_error' => 'ユーザー情報が一致しませんでした。再入力してください',
        ]);;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
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
