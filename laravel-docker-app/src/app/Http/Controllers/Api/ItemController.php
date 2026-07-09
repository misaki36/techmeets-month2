<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Resources\TaskResource; // TaskResourceを読み込む
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // タスク一覧取得
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks); // 一覧はcollectionで返す
    }

    // タスク1件取得
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return new TaskResource($task); // 1件はnewで返す
    }

    public function store(Request $request)
{
    // バリデーション：titleは必須、bodyは任意
    $validated = $request->validate([
        'title'   => 'required|string|max:255', // 必須・文字列・255文字以内
        'body'    => 'nullable|string',          // 任意・文字列
        'user_id' => 'required|integer',         // 必須・整数
    ]);

    // バリデーションを通過したデータでタスクを作成
    $task = Task::create($validated);

    // 作成したタスクをTaskResourceで返す
    return new TaskResource($task);
}
}