<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Tweet;
use App\Models\User;
use App\Models\Good;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class TimelineController extends Controller
{

    public function __construct()
    {
        $this->tweet = new Tweet;
    }

    /*
    * ログインチェック
    */
    public function loginConfirm(LoginRequest $request)
    {
        
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            $tweets = $this->tweet->with('user')->get()->toArray();

            $good = new Good();
            foreach($tweets as $key => $tweet){
                $result = $good->where('tweet_id',$tweet['id'])->where('user_id',Auth::user()->id)->get()->toArray();
                if($result){
                    $tweets[$key]['good'] = true;
                }else{
                    $tweets[$key]['good'] = false;
                }
            }
        
            return view('Auth.timeline',['tweets' => $tweets]);
        }

        return back()->withErrors([
            'login_error' => 'ユーザー情報が一致しませんでした。再入力してください',
        ]);;
    }

    /*
    * ログアウト
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /*
    * ツイートフォーム画面に遷移
    */
    public function formTimeline(){
        return view('form_timeline');
    }


    /*
    * 新規作成：ツイート
    */
    public function postTweet(TweetRequest $request) 
    {
        

        $this->tweet->user_id = Auth::user()->id;
        $this->tweet->tweet = $request->tweet;
        $this->tweet->save();
        if($this->tweet->save()){
            session()->flash('f_msg','ツイートしました');
        }else{
            session()->flash('f_msg','ツイート失敗しました');
        }

        $tweets = $this->tweet->all();
        
        return view('Auth.timeline',['tweets' => $tweets]);
    }

    /*
    * ツイート詳細表示
    */
    public function tweetDetail(int $tweet_id){
        $results = $this->tweet->with('user')->where('id','=',$tweet_id)->get()->toArray();

        $good = new Good();
        $result = $good->where('tweet_id',$tweet_id)->where('user_id',Auth::user()->id)->get()->toArray();
        if($result){
            $results[0]['good'] = true;
        }else{
            $results[0]['good'] = false;
        }
        return view('tweet_detail',['results' => $results]);
    }

    /*
    * マイページ画面
    */
    public function mypage(){
        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();

        return view('mypage',['results'=>$results]);
    }

    /*
    * ツイート編集画面
    */
    public function tweet_edit(int $id){
        $results = $this->tweet->where('id',$id)->get()->toArray();
        return view('tweet_edit',['results' => $results]);
    }

    /*
    * 編集入力ページ
    */
    public function edit_conf(TweetRequest $request,int $id){
        $tweet = $this->tweet->find($id);
        
        $tweet->tweet = $request->tweet;
        $tweet->save();

        if($tweet->save()){
            session()->flash('f_msg','ツイートを編集しました');
        }else{
            session()->flash('f_msg','ツイートの編集に失敗しました');
        }

        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();
 
        return view('mypage',['results'=>$results]);
    }

    /*
    * ページバック
    */
    public function back_page(Request $request){
        if($request['back_page'] == 'timeline'){
            $tweets = $this->tweet->with('user')->get()->toArray();

            return view('Auth.timeline',['tweets' => $tweets]);
        }elseif($request['back_page'] == 'mypage'){
            $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();

            return view('mypage',['results'=>$results]);
        }elseif($request['back_page'] == 'good'){
            $tweets = $this->tweet->with('user')->get()->toArray();
            $good = new Good();
            foreach($tweets as $key => $tweet){
                $result = $good->where('tweet_id',$tweet['id'])->where('user_id',Auth::user()->id)->get()->toArray();
                if($result){
                    $tweets[$key]['good'] = true;
                }else{
                    $tweets[$key]['good'] = false;
                }
            }

            return view('Auth.timeline',['tweets' => $tweets]);
        }
    }


    public function delete_tweet(int $id){
        $this->tweet->where('id',$id)->delete();

        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();
 
        return view('mypage',['results'=>$results]);
    }

    public function good_ajax(Request $request){
        $tweet_id = $request['tweet_id'];
        $user_id = $request['user_id'];

        $good = new Good();
        $result = $good->where('tweet_id',$tweet_id)->where('user_id',$user_id)->get()->toArray();
        if(!empty($result)){
            $good->where('tweet_id',$tweet_id)->where('user_id',$user_id)->delete();
            $data = response()->json('削除しました');
        }else{
            $good = new Good();
            $good->tweet_id = $tweet_id;
            $good->user_id = $user_id;
            $good->save();
            $data = response()->json('登録しました');
        }
        return $data;
    }
}
