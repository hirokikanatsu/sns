<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'twitter',
        'nickname'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function follows(){
        return $this->hasMany('App\Models\Follow','follower_id','id');
    }

    public function chats(){
        return $this->hasMany('App\Models\Chat','send_user_id','id');
    }

    //検索下文字列が含まれるユーザーを取得
    public function get_relational_users_name($user_name){
        return User::where('name','like','%'.$user_name.'%')->get()->toArray();
    }

    //ユーザー名のみ取得
    // public function scopegetUserName($query,$id)
    // {
    //     return $query->where('user_id',$id);
    // }
}
