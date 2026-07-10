<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

// リクエストを受け取って、Serviceに処理を任せるだけのクラス
class TaskController extends Controller
{
    // LaravelがTaskServiceを自動で渡してくれる（依存性注入）
    public function __construct(
        private TaskService $taskService
    ) {
    }

    // タスク一覧を表示
    public function index()
    {
        $tasks = $this->taskService->getAllTasks(auth()->id());
        return view('tasks.index', compact('tasks'));
    }

    // タスク作成フォームを表示
    public function create()
    {
        return view('tasks.create');
    }

    // タスクを保存
    public function store(Request $request)
    {
        // 入力値のバリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'nullable',
        ]);

        // ログイン中のユーザーIDを追加
        $validated['user_id'] = auth()->id();

        // Serviceにタスク作成を依頼
        $this->taskService->createTask($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを作成しました！');
    }

    // タスク編集フォームを表示
    public function edit(Task $task)
    {
        // 本人以外はアクセス不可（TaskPolicyのupdateメソッドで判定）
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    // タスクを更新
    public function update(Request $request, Task $task)
    {
        // 本人以外はアクセス不可（TaskPolicyのupdateメソッドで判定）
        $this->authorize('update', $task);

        // 入力値のバリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'nullable',
        ]);

        // Serviceに更新を依頼
        $this->taskService->updateTask($task, $validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました！');
    }

    // タスクを削除
    public function destroy(Task $task)
    {
        // 本人以外はアクセス不可（TaskPolicyのdeleteメソッドで判定）
        $this->authorize('delete', $task);

        // Serviceに削除を依頼
        $this->taskService->deleteTask($task);

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました！');
    }

    // 完了/未完了を切り替え
    public function toggle(Task $task)
    {
        // 本人以外はアクセス不可（TaskPolicyのtoggleメソッドで判定）
        $this->authorize('toggle', $task);

        // Serviceに切り替えを依頼
        $this->taskService->toggleComplete($task);

        return redirect()->route('tasks.index')->with('success', '更新しました！');
    }
}
