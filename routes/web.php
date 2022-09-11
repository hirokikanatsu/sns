<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TimelineController;

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




Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/back_page',[TimelineController::class,'back_page'])->name('back_page');

Route::group(['middleware' => ['guest']],function(){

    //ログイン
    Route::post('/login_conf', [TimelineController::class,'loginConfirm'])->name('login_conf');
    
    //ユーザー新規登録などの画面遷移はこちらに記載予定

    //ログイン画面へ遷移
    // Route::get('/login',[LoginController::class,'login_top'])->name('login');

});
 

Route::group(['middleware' => ['auth']],function(){

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
});








