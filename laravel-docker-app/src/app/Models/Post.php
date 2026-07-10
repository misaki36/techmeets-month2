<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    // 投稿はユーザーに属している
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 投稿のいいねはpost_likesテーブルで管理
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // いいねを追加する（同じユーザーが2回押しても1件だけ保存）
    public function like(int $userId): void
    {
        // firstOrCreate: すでに存在すれば取得、なければ作成（重複防止）
        PostLike::firstOrCreate([
            'post_id' => $this->id,
            'user_id' => $userId,
        ]);
    }

    // いいね数を返す（キャッシュを使って効率化）
    public function likesCount(): int
    {
        // withCount()でロード済みの場合はDBアクセスしない
        return $this->likes_count ?? $this->likes()->count();
    }
}
