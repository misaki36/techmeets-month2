<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'body', 'is_completed', 'user_id'];

    // タスクはユーザーに属している
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}