<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // 入力を許可するカラム
    protected $fillable = [
        'title',
        'content',
        'category',
    ];
}
