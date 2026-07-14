<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

// DBとのやりとりだけを担当するクラス
class PostRepository
{
    
    public function getAll()
{
    // Cache::remember: キャッシュがあればDBアクセスせずに返す
    // キャッシュがなければクロージャ内を実行してDBから取得し、キャッシュに保存する
    return Cache::remember('posts.all', now()->addMinutes(60), function () {
        return Post::with('user')
                   ->withCount('likes') // いいね数もまとめて取得
                   ->latest()
                   ->get();
    });
}

    // IDで1件取得（見つからなければ404）
    public function findById(int $id)
    {
        return Post::findOrFail($id);
    }

    // 投稿を新規作成
public function create(array $data)
{
    $post = Post::create($data);

    // 新しい投稿が追加されたのでキャッシュを削除
    Cache::forget('posts.all');

    return $post;
}

// 投稿を更新
public function update(Post $post, array $data)
{
    $post->update($data);

    // 投稿が更新されたのでキャッシュを削除
    Cache::forget('posts.all');

    return $post;
}

// 投稿を削除
public function delete(Post $post)
{
    // 投稿が削除されたのでキャッシュを削除
    Cache::forget('posts.all');

    return $post->delete();
}
}
