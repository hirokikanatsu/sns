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


// Route::group(['middleware' => ['guest']],function(){
    Route::get('/login',[LoginController::class,'login_top'])->name('login');
    Route::post('/login_conf', [TimelineController::class,'loginConfirm'])->name('login_conf');
// });

 

Route::group(['middleware' => ['auth']],function(){
    Route::post('/logout',[TimelineController::class,'logout'])->name('logout');
    Route::get('/timeline',[TimelineController::class,'formTimeline'])->name('timeline');
    Route::post('/timeline', [TimelineController::class,'postTweet'])->name('form_timeline');  
});








