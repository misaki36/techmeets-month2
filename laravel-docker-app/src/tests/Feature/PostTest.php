<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// RefreshDatabase: 各テスト後にDBを自動リセットする（テスト同士が干渉しない）
class PostTest extends TestCase
{
    use RefreshDatabase;

    // ===== 表示系のテスト =====

    // 【正常系】投稿一覧ページが表示されるか
    public function test_user_can_view_posts_index()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create();
        $response = $this->actingAs($user)->get('/posts');
        $response->assertStatus(200);
    }

    // 【異常系】未ログインユーザーは投稿一覧にアクセスできないか
    public function test_guest_cannot_view_posts_index()
    {
        $response = $this->get('/posts');
        $response->assertRedirect('/login');
    }

    // ===== 作成系のテスト =====

    // 【正常系】ログイン済みユーザーが投稿を作成できるか
    public function test_authenticated_user_can_create_post()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'テスト投稿タイトル',
            'body'  => 'テスト投稿の本文です。',
        ]);
        $response->assertRedirect('/posts');
        $this->assertDatabaseHas('posts', [
            'title'   => 'テスト投稿タイトル',
            'user_id' => $user->id,
        ]);
    }

    // 【異常系】未ログインユーザーは投稿できないか
    public function test_guest_cannot_create_post()
    {
        $response = $this->post('/posts', [
            'title' => 'テスト投稿',
            'body'  => 'テスト本文',
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('posts', ['title' => 'テスト投稿']);
    }

    // ===== 更新系のテスト =====

    // 【正常系】投稿者本人が投稿を更新できるか
    public function test_author_can_update_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->put("/posts/{$post->id}", [
            'title' => '更新後タイトル',
            'body'  => '更新後の本文です。',
        ]);
        $response->assertRedirect('/posts');
        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => '更新後タイトル',
        ]);
    }

    // ===== 削除系のテスト =====

    // 【正常系】投稿者本人が投稿を削除できるか
    public function test_author_can_delete_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->delete("/posts/{$post->id}");
        $response->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    // 【異常系】他のユーザーの投稿は削除できないか
    public function test_user_cannot_delete_others_post()
    {
        $author = User::factory()->create();
        $other  = User::factory()->create();
        $post   = Post::factory()->create(['user_id' => $author->id]);
        $response = $this->actingAs($other)->delete("/posts/{$post->id}");
        $response->assertStatus(403);
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    // ===== バリデーションのテスト =====

    // 【異常系】タイトルが空のとき投稿できないか
    public function test_post_requires_title()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/posts', [
            'title' => '', // タイトルが空
            'body'  => 'テスト本文です。',
        ]);
        // バリデーションエラーが返るか
        $response->assertSessionHasErrors(['title']);
    }

    // 【異常系】本文が空のとき投稿できないか
    public function test_post_requires_body()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'テストタイトル',
            'body'  => '', // 本文が空
        ]);
        // バリデーションエラーが返るか
        $response->assertSessionHasErrors(['body']);
    }
}