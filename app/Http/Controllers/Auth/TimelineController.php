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
use App\Events\TaskAdded;

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
    * ログイン成功
    */
    public function login_success(Request $request){

        $tweets = Tweet::followingTweets()->paginate(10);

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
        if($request->has('image')){
            $image_file = $request->file('image');
            $temp_path = $image_file->store('public');
            $image_name = basename($temp_path);
        }
        $this->tweet->file_name = $image_name;

        $this->tweet->save();
        if($this->tweet->save()){
            session()->flash('f_msg','ツイートしました');
        }else{
            session()->flash('f_msg','ツイート失敗しました');
        }

        $tweets = Tweet::followingTweets()->paginate(10);

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
        if($request->has('image')){
            $image_file = $request->file('image');
            $temp_path = $image_file->store('public');
            $image_name = basename($temp_path);
        }
        $tweet->file_name = $image_name;
        $tweet->save();

        if($tweet->save()){
            session()->flash('f_msg','ツイートを編集しました');
        }else{
            session()->flash('f_msg','ツイートの編集に失敗しました');
        }

        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();
        $request->session()->put('key', $results);
 
        return view('mypage',['tweets'=>$results]);
    }

    /*
    * ページバック
    */
    public function back_page(Request $request){
        if($request['back_page'] == 'mypage'){ //ツイート編集ページからマイページへ遷移

            $tweets = $this->tweet->with('user')->where('user_id',Auth::user()->id)->get()->toArray();
            
            return view('mypage',['tweets'=>$tweets]);
        }elseif($request['back_page'] == 'search_users_form'){
            return view('search_users_form');
        }else{ //上記以外の全ての「戻る」ボタン

            $tweets = Tweet::followingTweets()->paginate(10);

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
        $params = $request->only('name','email','password','password_confirmation');
        
        $login_user = $this->user->where('id',Auth::user()->id)->first();

        if($request->has(['name', 'email','password','password_confirmation'])){
            $login_user = $this->user->where('id',Auth::user()->id)->first();

            if($request->has('image')){
                $image_file = $request->file('image');
                $temp_path = $image_file->store('public');
                $image_name = basename($temp_path);

                if(!empty($login_user->image)){
                    Storage::disk('public')->delete($login_user->image);
                }

                $login_user->image = $image_name;
            }

            $login_user->name = $params['name'];
            $login_user->email = $params['email'];
            $login_user->save();
        }
        

        if(session('new_image') !== ''){
            session()->forget('new_image');
        }

        session()->push('new_image', $login_user->image);

        $results = $this->tweet->where('user_id','=',Auth::user()->id)->get()->toArray();

        return view('mypage',['tweets'=>$results]);

    }

    //無限スクロール（ツイート読み込み）
    public function infinite_scroll(Request $request){
        $count = $request['count'];
        $records = Tweet::followingTweets()->with('user')->offset($count)->limit(2)->get();
        // $records = User::getUserName()->toArray();

        return json_encode($records);
    }

    /*
    * 動画視聴機能
    */
    public function watch_movie(Request $request, string $movie_path){
        $path = storage_path($movie_path); 

        $file_name = basename($path);
        $real_path = '/var/www/laravel/public/storage/'.$file_name;
        $file_size = filesize($real_path);
        $fp = fopen($real_path, 'rb');
        $status_code = 200;
        $headers = [
            'Content-type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $file_size
        ];
        // $range = $request->header('Range');

        return response()->stream(function() use($fp) {

            fpassthru($fp);
    
        }, $status_code, $headers);
    
    }


    //phpunitのテスト用
    public function addnumber($a,$b){
        return $a + $b ;
    }

    public function get_all_tweet($user_id){
        $this->tweet->with('user')->where('user_id','!=',$user_id)->get()->toArray();
    }

    //検索対象ユーザー情報
    public function user_profile(int $id){
        $user_infomations =  $this->tweet->get_user_info($id);
        return view('searched_profile',['tweets'=>$user_infomations]); 
    }

}
