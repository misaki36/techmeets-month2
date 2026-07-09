<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    // post_idとuser_idを一括代入可能にする
    protected $fillable = ['post_id', 'user_id'];

    // いいねは投稿に属している
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // いいねはユーザーに属している
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
