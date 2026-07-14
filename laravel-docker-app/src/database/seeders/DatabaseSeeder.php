<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // テスト用ユーザーを10人作成
    $users = User::factory(10)->create();

    // 各ユーザーに5件ずつ投稿を作成（合計50件）
    $users->each(function ($user) {
        \App\Models\Post::factory(5)->create([
            'user_id' => $user->id,
        ]);
    });
}
}
