<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TimelineController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TwitterLoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GoogleController;
use App\Events\TaskAdded;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tasks', function () {

    // broadcast(new \App\Events\TaskAdded());
    $test = ['id' => 1, 'name' => 'メールの確認'];
    event(new TaskAdded($test));

    return view('welcome');
    // $test = 'あいうえお';

    // event(new TaskAdded($test));
});


Auth::routes();



Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/back_page',[TimelineController::class,'back_page'])->name('back_page');

Route::group(['middleware' => ['guest']],function(){

    //ログイン
    Route::post('/login_conf',[LoginController::class,'login'])->name('login_conf');

    // Route::get('auth/login/twitter', [TwitterLoginController::class, 'redirectToProvider'])->name('auth/login/twitter');

    // Route::get('auth/twitter/callback',[TwitterLoginController::class, 'handleProviderCallback']);



    // Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    
    // Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])->name('login/google');
    // Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

});
 
Route::get('auth/login/twitter', [LoginController::class, 'redirectToProvider'])->name('auth/login/twitter');

Route::get('auth/twitter/callback',[LoginController::class, 'handleProviderCallback']);

Route::group(['middleware' => ['auth']],function(){

    //トップページ
    Route::get('/login_success',[TimelineController::class,'login_success'])->name('login_success');

    //無限スクロール（ツイート読み込み）
    Route::post('/infinite_scroll',[TimelineController::class,'infinite_scroll'])->name('infinite_scroll');

    //プロフィール編集実行
    Route::post('edit_myprofile',[TimelineController::class,'edit_myprofile'])->name('edit_myprofile');

    //プロフィール編集画面
    Route::get('myprofile',[TimelineController::class,'myprofile'])->name('myprofile');

    //ユーザーフォローAjax
    Route::post('/follow_ajax',[TimelineController::class,'follow_ajax'])->name('follow_ajax');

    //ユーザープロフィール
    Route::get('/profile/{id}',[TimelineController::class,'profile'])->name('profile');

    //いいね用Ajax
    Route::post('good_ajax',[TimelineController::class,'good_ajax'])->name('good_ajax');

    //ツイート削除
    Route::get('/delete_tweet/{id}',[TimelineController::class,'delete_tweet'])->name('delete_tweet');

    //編集入力ページ
    Route::post('/edit_conf/{id}',[TimelineController::class,'edit_conf'])->name('edit_conf');

    //編集ページ
    Route::get('/tweet_edit/{id}',[TimelineController::class,'tweet_edit'])->name('tweet_edit');

    //マイページ
    Route::get('/mypage',[TimelineController::class,'mypage'])->name('mypage');
    
    //ツイート詳細画面
    Route::get('/tweet.detail/{id}',[TimelineController::class,'tweetDetail'])->name('tweet.detail');

    //ログアウト
    Route::post('/logout',[TimelineController::class,'logout'])->name('logout');

    //ツイート作成画面
    Route::get('/timeline',[TimelineController::class,'formTimeline'])->name('timeline');

    //ツイート作成
    Route::post('/timeline', [TimelineController::class,'postTweet'])->name('form_timeline');

    //メール送信
    Route::get('/mail/send', [MailController::class,'send'])->name('mail');

    //動画視聴
    Route::get('/watch_movie/{movie_path}',[TimelineController::class,'watch_movie'])->name('watch_movie');

    //ユーザー検索フォーム
    Route::get('/search_users_form',[UserController::class,'search_users_form'])->name('search_users_form');

    //ユーザー検索
    Route::post('/search_users',[UserController::class,'search_users'])->name('search_users');

    //ユーザープロフィール
    Route::get('/user_profile/{id}',[TimelineController::class,'user_profile'])->name('user_profile');

    //チャットフォーム画面
    Route::get('dm_form/{id}',[ChatController::class,'dm_form'])->name('dm_form');

    //チャット保存
    Route::post('store_chat',[ChatController::class,'store_chat'])->name('store_chat');


});







