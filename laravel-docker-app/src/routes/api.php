<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;

// タスク一覧取得
Route::get('/tasks', [ItemController::class, 'index']);

// タスク1件取得
Route::get('/tasks/{id}', [ItemController::class, 'show']);

// タスク新規作成
Route::post('/tasks', [ItemController::class, 'store']);