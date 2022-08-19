<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Follow;
use App\Models\Tweet;
use App\Models\User;
use App\Models\Good;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class TimelineController extends Controller
{

    public function __construct()
    {
        $this->tweet = new Tweet;
        $this->follow = new Follow;
        $this->good = new Good;
        $this->user = new User;
    }

    /*
    * ログインチェック
    */
    public function loginConfirm(LoginRequest $request)
    {
        
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            $results = $this->tweet->with('user')->where('user_id','!=',Auth::user()->id)->get()->toArray();


            $following_users = $this->follow->where('follower_id',Auth::user()->id)->get()->toArray();

            $user_ids = [];
            $tweets = [];

            foreach($following_users as $following_user){
                $user_ids[] = $following_user['follow_id'];
            }

            foreach($results as $result){
                if(is_array($user_ids)){
                    foreach($user_ids as $user_id){
                        if($result['user_id'] == $user_id){
                            $tweets[] = $result;
                        }
                    }
                }else{
                    if($result['user_id'] == $user_ids){
                        $tweets[] = $result;
                    }
                }
            }

            if($tweets == []){
                $tweets = 'ツイートがありません';
            }else{
                foreach($tweets as $key => $tweet){
                    $result = $this->good->where('tweet_id',$tweet['id'])->where('user_id',Auth::user()->id)->get()->toArray();
                    if($result){
                        $tweets[$key]['good'] = true;
                    }else{
                        $tweets[$key]['good'] = false;
                    }
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

        $result = $this->good->where('tweet_id',$tweet_id)->where('user_id',Auth::user()->id)->get()->toArray();
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

        return view('mypage',['tweets'=>$results]);
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
        $request->session()->put('key', $results);
 
        return view('mypage',['results'=>$results]);
    }

    /*
    * ページバック
    */
    public function back_page(Request $request){
        if($request['back_page'] == 'timeline'){ //ツイートフォームからタイムラインへ遷移

            $results = $this->tweet->with('user')->where('user_id','!=',Auth::user()->id)->get()->toArray();

            $following_users = $this->follow->where('follower_id',Auth::user()->id)->get()->toArray();

            $user_ids = [];
            $tweets = [];

            foreach($following_users as $following_user){
                $user_ids[] = $following_user['follow_id'];
            }

            foreach($results as $result){
                if(is_array($user_ids)){
                    foreach($user_ids as $user_id){
                        if($result['user_id'] == $user_id){
                            $tweets[] = $result;
                        }
                    }
                }else{
                    if($result['user_id'] == $user_ids){
                        $tweets[] = $result;
                    }
                }
            }

            if($tweets == []){
                $tweets = 'ツイートがありません';
            }else{
                foreach($tweets as $key => $tweet){
                    $result = $this->good->where('tweet_id',$tweet['id'])->where('user_id',Auth::user()->id)->get()->toArray();
                    if($result){
                        $tweets[$key]['good'] = true;
                    }else{
                        $tweets[$key]['good'] = false;
                    }
                }
            }

            return view('Auth.timeline',['tweets' => $tweets]);

        }elseif($request['back_page'] == 'mypage'){ //ツイート編集ページからマイページへ遷移

            $tweets = $this->tweet->with('user')->where('user_id',Auth::user()->id)->get()->toArray();
            
            return view('mypage',['tweets'=>$tweets]);

        }elseif($request['back_page'] == 'good'){

            $results = $this->tweet->with('user')->where('user_id','!=',Auth::user()->id)->get()->toArray();

            $following_users = $this->follow->where('follower_id',Auth::user()->id)->get()->toArray();

            $user_ids = [];
            $tweets = [];

            foreach($following_users as $following_user){
                $user_ids[] = $following_user['follow_id'];
            }

            foreach($results as $result){
                if(is_array($user_ids)){
                    foreach($user_ids as $user_id){
                        if($result['user_id'] == $user_id){
                            $tweets[] = $result;
                        }
                    }
                }else{
                    if($result['user_id'] == $user_ids){
                        $tweets[] = $result;
                    }
                }
            }

            if($tweets == []){
                $tweets = 'ツイートがありません';
            }else{
                foreach($tweets as $key => $tweet){
                    $result = $this->good->where('tweet_id',$tweet['id'])->where('user_id',Auth::user()->id)->get()->toArray();
                    if($result){
                        $tweets[$key]['good'] = true;
                    }else{
                        $tweets[$key]['good'] = false;
                    }
                }
            }

            return view('Auth.timeline',['tweets' => $tweets]);
        }
    }


    /*
    * ツイート削除
    */
    public function delete_tweet(int $id){
        $this->tweet->where('id',$id)->delete();

        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();
 
        return view('mypage',['results'=>$results]);
    }

    /*
    * いいね機能用Ajax
    */
    public function good_ajax(Request $request){
        $tweet_id = $request['tweet_id'];
        $user_id = $request['user_id'];

        $result = $this->good->where('tweet_id',$tweet_id)->where('user_id',$user_id)->get()->toArray();
        if(!empty($result)){
            $this->good->where('tweet_id',$tweet_id)->where('user_id',$user_id)->delete();
            $data = response()->json('削除しました');
        }else{
            $this->good->tweet_id = $tweet_id;
            $this->good->user_id = $user_id;
            $this->good->save();
            $data = response()->json('登録しました');
        }
        return $data;
    }

    /*
    * ユーザープロフィール表示
    */
    public function profile(int $id){

        $tweets = $this->tweet->with('user')->where('user_id',$id)->get()->toArray();

        $result = $this->follow->where('follow_id',$tweets[0]['user']['id'])->where('follower_id',Auth::user()->id)->get()->toArray();

        if(!empty($result)){
            $is_follow = 'フォロー中';
        }else{
            $is_follow = 'フォロー';
        }

        return view('profile',['tweets'=>$tweets,'is_follow'=>$is_follow]);
    }

    /*
    * ユーザーフォローAjax
    */
    public function follow_ajax(Request $request){
        $follow_id = $request['follow_id'];
        $follower_id = $request['follower_id'];

        $result = $this->follow->where('follow_id',$follow_id)->where('follower_id',$follower_id)->get()->toArray();

        if(!empty($result)){
            $this->follow->where('follow_id',$follow_id)->where('follower_id',$follower_id)->delete();
            return response()->json('フォローを解除しました');
        }else{
            $this->follow->follow_id = $follow_id;
            $this->follow->follower_id = $follower_id;
            $this->follow->save();
            return response()->json('フォローしました');
        }
    }

    /*
    * マイプロフィール編集画面
    */
    public function myprofile(){
        return view('edit_myprofile');
    }

    /*
    * マイプロフィール編集実行
    */
    public function edit_myprofile(ProfileRequest $request){
        $image_file = $request->file('image');
        $temp_path = $image_file->store('public');
        $image_name = basename($temp_path);

        $login_user = $this->user->where('id',Auth::user()->id)->first();

        if(!empty($login_user->image)){
            Storage::disk('public')->delete($login_user->image);
        }

        $login_user->image = $image_name;
        $login_user->save();

        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();

        return view('mypage',['tweets'=>$results]);

    }



    public function get_all_tweet($user_id){
        $this->tweet->with('user')->where('user_id','!=',$user_id)->get()->toArray();
    }

}
