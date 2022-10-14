<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [   
        'follow_id', 'follower_id',
    ];

    //ログインユーザーのフォローしてるユーザーIDを全て取得
    public function scopeFollowIds($query)
    {
        return $query->where('follower_id',\Auth::id())->pluck('follow_id')->toArray();
    }
}
