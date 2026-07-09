<?php

namespace App\Repositories;

use App\Models\Post;

// DBとのやりとりだけを担当するクラス
class PostRepository
{
    // 投稿を全件取得（投稿者情報も一緒に取得）
    public function getAll()
    {
        return Post::with('user')->latest()->get();
    }

    // IDで1件取得（見つからなければ404）
    public function findById(int $id)
    {
        return Post::findOrFail($id);
    }

    // 投稿を新規作成
    public function create(array $data)
    {
        return Post::create($data);
    }

    // 投稿を更新
    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    // 投稿を削除
    public function delete(Post $post)
    {
        return $post->delete();
    }
}
