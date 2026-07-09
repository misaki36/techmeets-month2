<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// いいね機能のユニットテスト
class PostLikesTest extends TestCase
{
    use RefreshDatabase;

    // 【正常系】いいねが0件のとき0を返すか
    public function test_likes_count_returns_zero_when_no_likes()
    {
        // ①Arrange: ダミーの投稿を作成
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // ②Act: いいね数を取得
        $count = $post->likesCount();

        // ③Assert: 0が返るか
        $this->assertEquals(0, $count);
    }

    // 【正常系】いいねを1件追加したら1を返すか
    public function test_likes_count_returns_one_after_one_like()
    {
        // ①Arrange: 投稿といいねするユーザーを作成
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // ②Act: いいねを追加してからカウントを取得
        $post->like($user->id);
        $count = $post->likesCount();

        // ③Assert: 1が返るか
        $this->assertEquals(1, $count);
    }

    // 【正常系】同じユーザーが2回いいねしても1のままか（重複防止）
    public function test_likes_count_does_not_duplicate()
    {
        // ①Arrange
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // ②Act: 同じユーザーが2回いいね
        $post->like($user->id);
        $post->like($user->id);
        $count = $post->likesCount();

        // ③Assert: 重複しないので1のまま
        $this->assertEquals(1, $count);
    }

    // 【正常系】異なるユーザーがいいねすると合計が増えるか
    public function test_likes_count_increases_with_different_users()
    {
        // ①Arrange: 投稿と2人のユーザーを作成
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post  = Post::factory()->create(['user_id' => $user1->id]);

        // ②Act: 2人がそれぞれいいね
        $post->like($user1->id);
        $post->like($user2->id);
        $count = $post->likesCount();

        // ③Assert: 2が返るか
        $this->assertEquals(2, $count);
    }
}
