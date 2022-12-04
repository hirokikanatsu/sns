<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [   
        'send_user_id', 'receive_user_id','contents'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','send_user_id','id');
    }

    //チャット保存
    public function store_chat($send_user,$receive_user,$contents){
        $chat = new Chat();

        $chat->send_user_id = $send_user;
        $chat->receive_user_id = $receive_user;
        $chat->contents = $contents;

        $chat->save();
    }
}
