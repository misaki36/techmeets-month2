<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            // fake()はダミーデータを自動生成してくれるヘルパー
            'title' => fake()->sentence(),      // ダミーのタイトル（文章）
            'body'  => fake()->paragraph(),     // ダミーの本文（段落）
            // User::factory()で同時にダミーユーザーも作成
            'user_id' => User::factory(),
        ];
    }
}
