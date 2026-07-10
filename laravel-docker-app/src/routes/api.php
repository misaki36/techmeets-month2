<?php

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle']);

// タスク一覧取得
Route::get('/tasks', [ItemController::class, 'index']);

// タスク1件取得
Route::get('/tasks/{id}', [ItemController::class, 'show']);

// タスク新規作成
Route::post('/tasks', [ItemController::class, 'store']);
