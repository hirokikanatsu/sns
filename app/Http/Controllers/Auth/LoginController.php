<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Tweet;
use App\Models\Follow;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/welcome';
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tweet = new Tweet;
        $this->good = new Good;
        $this->follow = new Follow;
        $this->user = new User;
        // $this->middleware('guest')->except('logout');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('login_success');
        }
        return redirect()->route('home');
    }

    public function login_top(){
        
        return  view('Auth.login');
    }


    /**
      * Twitterの認証ページヘユーザーをリダイレクト
      *
      * @return \Illuminate\Http\Response
      */
      public function redirectToProvider()
      {
        return  Socialite::driver('twitter')->redirect();
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
            return redirect('/welcome');
         }

          if(User::where('email', $twitterUser->getEmail())->exists()){
             //ツイッターで作成されたユーザーならそのままパスする
            $user = User::where('email', $twitterUser->getEmail())->first();
            Auth::login($user);
            return redirect('/login_success');
          }else{
             $user = new User();
             //ユーザーに必要な情報
            $user->name = $twitterUser->getName();
            $user->email = $twitterUser->getEmail();
            $user->password = md5(Str::uuid());
            $user->twitter = 1;
            $user->nickname = $twitterUser->getNickname();
            $user->save();
             
          }

          Auth::login($user);
          return redirect('/login_success');
      }

}
