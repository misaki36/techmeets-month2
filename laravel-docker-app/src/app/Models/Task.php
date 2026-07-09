<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 追加
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // 追加（factory()メソッドが使えるようになる）

    protected $fillable = ['title', 'body', 'is_completed', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
