<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tweet;

class Good extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [   
        'user_id', 'tweet_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function tweet(){
        return $this->hasOne(Tweet::class);
    }
}
