<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [   
        'user_id', 'tweet','file_name'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    //ログインユーザーのユーザーIDと違うもの
    public function scopeNotMyself($query)
    {
        return $query->where('user_id','!=', \Auth::id());
    }

    //自分以外のフォローしてるユーザーのツイートを取得
    public function scopeFollowingTweets($query)
    {
        return $query->notMyself()->where('user_id', Follow::followIds());
    }
    
}
