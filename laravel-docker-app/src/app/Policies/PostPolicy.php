<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

// 認可ルールを一箇所にまとめるクラス
// 「誰がどの操作をしていいか」を定義する
class PostPolicy
{
    // 投稿の編集は投稿者本人のみ許可
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    // 投稿の削除は投稿者本人のみ許可
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
