<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;

class UserController extends Controller
{

    public function __construct()
    {
        $this->user = new User;
        $this->chat = new Chat;
    }

    //ユーザー検索フォーム
    public function search_users_form(){
        return view('search_users_form');
    }

    //ユーザー検索
    public function search_users(Request $request){

        // 受け取ったユーザー名からヒットするユーザーを検索
        $user_name = $request->user_name;
        $relational_users_name = $this->user->get_relational_users_name($user_name);
        return view('search_users_form',['user_name'=>$relational_users_name]);
    }

}
