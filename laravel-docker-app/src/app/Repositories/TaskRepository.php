<?php

namespace App\Repositories;

use App\Models\Task;

// DBとのやりとりだけを担当するクラス
class TaskRepository
{
    // ログインユーザーのタスクを全件取得
    public function getAllByUser(int $userId)
    {
        return Task::where('user_id', $userId)->latest()->get();
    }

    // IDで1件取得（見つからなければ404）
    public function findById(int $id)
    {
        return Task::findOrFail($id);
    }

    // タスクを新規作成
    public function create(array $data)
    {
        return Task::create($data);
    }

    // タスクを更新
    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    // タスクを削除
    public function delete(Task $task)
    {
        return $task->delete();
    }

    // 完了/未完了を切り替え
    public function toggleComplete(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);
        return $task;
    }
}
