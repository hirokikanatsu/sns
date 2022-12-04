<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class twitterLoginController extends Controller
{
    /**
      * Twitterの認証ページヘユーザーをリダイレクト
      *
      * @return \Illuminate\Http\Response
      */
      public function redirectToProvider()
      {
        return  Socialite::driver('twitter')->redirect();
        // dd($user);
        //    dd(Socialite::driver('twitter')->user());
      }
      /**
       * Twitterからユーザー情報を取得(Callback先)
       *
       * @return \Illuminate\Http\Response
       */    
      public function handleProviderCallback()
      {
         try {
             $twitterUser = Socialite::driver('twitter')->user();
         } catch (Exception $e) {
             return redirect('auth/twitter');
         }
          if(User::where('email', $twitterUser->getEmail())->exists()){
             //ツイッターで作成されたユーザーならそのままパスする
             $user = User::where('email', $twitterUser->getEmail())->first();
             if(!$user->twitter){
                 dd("すでに同じメールアドレスが登録されています。");
             }
          }else{
             $user = new User();
             //ユーザーに必要な情報
             $user->name = $twitterUser->getName();
             $user->email = $twitterUser->getEmail();
             $user->password = md5(Str::uuid());
             $user->profile_photo_path = $twitterUser->getAvatar();
             $user->twitter = true;
             $user->nickname = $twitterUser->getNickname();
             $user->save();
             
          }
          Log::info('Twitterから取得しました。', ['user' => $twitterUser]);
          Auth::login($user);
          return redirect('auth/timeline');
      }
    // SNSログインコールバックのメソッド
    // public function handleProviderCallback()
    // {
    //     // $userSocial = Socialite::driver('twitter')->stateless()->user();
    //     // $user = User::where(['email' => $userSocial->getEmail()])->first();

    //     // if ($user) {
    //     //     Auth::login($user);
    //     // } else {
    //     //     $newuser = new User;
    //     //     $newuser->name = $userSocial->getName();
    //     //     $newuser->email = $userSocial->getEmail();
    //     //     $newuser->save();

    //     //     Auth::login($newuser);
    //     // }
    //     // $uri = "/home";
    //     // if (session()->has("login_after_url")) {   // ログイン後リダイレクト
    //     //     $uri = session("login_after_url");     
    //     //     session()->forget("login_after_url");
    //     // }
    //     try {
    //         // ユーザー詳細情報の取得
    //         $user = Socialite::driver('twitter')->user();
    //     } catch (Exception $e) {
    //         return redirect('auth/login/twitter');
    //     }
    //     return redirect('/login_conf');
    // }
}
