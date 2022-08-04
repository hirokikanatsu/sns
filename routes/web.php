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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::post('/home', [TimelineController::class,'showTimelinePage'])->name('tweet_top');
Route::get('/timeline',[TimelineController::class,'formTimeline'])->name('timeline');
Route::post('/timeline', [TimelineController::class,'postTweet'])->name('form_timeline');   


Route::get('/login',[LoginController::class,'login_top'])->name('login');







