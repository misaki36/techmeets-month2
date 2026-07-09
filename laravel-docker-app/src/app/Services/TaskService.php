<?php

namespace App\Services;

use App\Repositories\TaskRepository;

// ビジネスロジックを担当するクラス
class TaskService
{
    // LaravelがTaskRepositoryを自動で渡してくれる（依存性注入）
    public function __construct(
        private TaskRepository $taskRepository
    ) {
    }

    // ログインユーザーのタスクを全件取得
    public function getAllTasks(int $userId)
    {
        return $this->taskRepository->getAllByUser($userId);
    }

    // 1件取得をRepositoryに依頼
    public function getTaskById(int $id)
    {
        return $this->taskRepository->findById($id);
    }

    // 作成をRepositoryに依頼
    public function createTask(array $data)
    {
        return $this->taskRepository->create($data);
    }

    // 更新をRepositoryに依頼
    public function updateTask($task, array $data)
    {
        return $this->taskRepository->update($task, $data);
    }

    // 削除をRepositoryに依頼
    public function deleteTask($task)
    {
        return $this->taskRepository->delete($task);
    }

    // 完了/未完了の切り替えをRepositoryに依頼
    public function toggleComplete($task)
    {
        return $this->taskRepository->toggleComplete($task);
    }
}
