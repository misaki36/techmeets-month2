<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class);

    // タスク管理
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
});

// 掲示板は未ログインでも閲覧・投稿可能、削除だけ認証必須
Route::resource('threads', ThreadController::class)->except(['destroy']);
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->middleware('auth')->name('threads.destroy');

require __DIR__.'/auth.php';