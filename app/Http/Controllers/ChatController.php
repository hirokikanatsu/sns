<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Events\TaskAdded;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->chat = new Chat;
    }

    //チャット画面に遷移
    public function dm_form(int $user_id){
        $query = '';
        $items = [
            'user_id' => $user_id,
            'query' => $query
        ];
        $message = DB::table('chats')
                        ->where('send_user_id',Auth::id())
                        ->where('receive_user_id',$user_id);
        $messages = DB::table('chats')
                        ->where('send_user_id',$user_id)
                        ->where('receive_user_id',Auth::id())
                        ->union($message)
                        ->orderBy('created_at','asc')
                        ->get()
                        ->toArray();

        // $messages = Chat::where('send_user_id',Auth::id())
        //                 ->where('receive_user_id',$user_id)
                        //1ではなくuser_idで動的に処理したいが、functionに引数として渡してもエラー出る
                        // ->orwhere(function($query,$user_id){
                        //     $query->where('send_user_id',$user_id)
                        //           ->where('receive_user_id',Auth::id());
                        //     })
                        // ->with('user')
                        // ->get()
                        // ->toArray();
                        // ->orwhere(function($query){
                        //     $query->where('send_user_id',1)
                        //           ->where('receive_user_id',Auth::id());
                        //     })
        return view('dm_form',['id'=>$user_id,'messages'=>$messages]);
    }

    //チャット保存
    public function store_chat(Request $request){
        $chat = [];
        $send_user = $request['send_user'];
        $receive_user = $request['receive_user'];
        $contents = $request['contents'];

        $this->chat->store_chat($send_user,$receive_user,$contents);

        $chat = [
            'send_user' => $send_user,
            'receive_user' => $receive_user,
            'contents' => $contents
        ];

        event(new TaskAdded($chat));

        return response()->json($chat);
    }
}
