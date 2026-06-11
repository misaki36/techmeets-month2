<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

// 認可ルールを一箇所にまとめるクラス
// 「誰がどの操作をしていいか」を定義する
class TaskPolicy
{
    // タスクの編集は作成者本人のみ許可
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    // タスクの削除は作成者本人のみ許可
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    // 完了/未完了の切り替えは作成者本人のみ許可
    public function toggle(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}