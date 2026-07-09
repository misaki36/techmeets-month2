<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(),   // ダミーのタイトル
            'body'         => fake()->paragraph(),  // ダミーの本文
            // false/trueをランダムに生成（初期状態は未完了が多いのでfalse固定でもOK）
            'is_completed' => false,
            'user_id'      => User::factory(),      // ダミーユーザーも同時作成
        ];
    }
}
