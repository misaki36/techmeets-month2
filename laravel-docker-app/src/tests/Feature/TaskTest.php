<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    // ===== 表示系のテスト =====

    // 【正常系】ログイン済みユーザーがタスク一覧を見られるか
    public function test_authenticated_user_can_view_tasks()
    {
        // ①Arrange: ユーザーとそのユーザーのタスクを作成
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        // ②Act: ログイン状態でタスク一覧にアクセス
        $response = $this->actingAs($user)->get('/tasks');

        // ③Assert: 200が返るか
        $response->assertStatus(200);
    }

    // 【異常系】未ログインユーザーはタスク一覧にアクセスできないか
    public function test_guest_cannot_view_tasks()
    {
        // ②Act: ログインせずにタスク一覧にアクセス
        $response = $this->get('/tasks');

        // ③Assert: ログインページにリダイレクトされるか
        $response->assertRedirect('/login');
    }

    // ===== 作成系のテスト =====

    // 【正常系】ログイン済みユーザーがタスクを作成できるか
    public function test_authenticated_user_can_create_task()
    {
        // ①Arrange: ダミーユーザーを作成
        $user = User::factory()->create();

        // ②Act: ログイン状態でタスクを送信
        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'テストタスク',
            'body'  => 'テストタスクの詳細です。',
        ]);

        // ③Assert: タスク一覧にリダイレクトされるか
        $response->assertRedirect('/tasks');

        // DBにタスクが保存されているか
        $this->assertDatabaseHas('tasks', [
            'title'   => 'テストタスク',
            'user_id' => $user->id,
        ]);
    }

    // 【異常系】未ログインユーザーはタスクを作成できないか
    public function test_guest_cannot_create_task()
    {
        // ②Act: ログインせずにタスクを送信
        $response = $this->post('/tasks', [
            'title' => 'テストタスク',
            'body'  => 'テスト詳細',
        ]);

        // ③Assert: ログインページにリダイレクトされるか
        $response->assertRedirect('/login');
    }

    // ===== 更新系のテスト =====

    // 【正常系】タスクの所有者が更新できるか
    public function test_owner_can_update_task()
    {
        // ①Arrange: ユーザーとそのユーザーのタスクを作成
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // ②Act: 所有者としてログインして更新
        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title' => '更新後タスク',
            'body'  => '更新後の詳細です。',
        ]);

        // ③Assert: タスク一覧にリダイレクトされるか
        $response->assertRedirect('/tasks');

        // DBが更新されているか
        $this->assertDatabaseHas('tasks', [
            'id'    => $task->id,
            'title' => '更新後タスク',
        ]);
    }

    // ===== 削除系のテスト =====

    // 【正常系】タスクの所有者が削除できるか
    public function test_owner_can_delete_task()
    {
        // ①Arrange: ユーザーとそのユーザーのタスクを作成
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // ②Act: 所有者としてログインして削除
        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        // ③Assert: タスク一覧にリダイレクトされるか
        $response->assertRedirect('/tasks');

        // DBからタスクが削除されているか
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    // 【異常系】他のユーザーのタスクは削除できないか
    public function test_user_cannot_delete_others_task()
    {
        // ①Arrange: タスク所有者と別のユーザーを作成
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = Task::factory()->create(['user_id' => $owner->id]);

        // ②Act: 別のユーザーとしてログインして削除を試みる
        $response = $this->actingAs($other)->delete("/tasks/{$task->id}");

        // ③Assert: 403（権限なし）が返るか
        $response->assertStatus(403);

        // DBにタスクがまだ残っているか
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }

    // ===== toggle（完了/未完了切り替え）のテスト =====

    // 【正常系】未完了のタスクを完了に切り替えられるか
    public function test_owner_can_toggle_task_complete()
    {
        // ①Arrange: 未完了のタスクを作成（is_completed=false）
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id'      => $user->id,
            'is_completed' => false, // 最初は未完了
        ]);

        // ②Act: toggleエンドポイントにリクエスト
        $response = $this->actingAs($user)->patch("/tasks/{$task->id}/toggle");

        // ③Assert: タスク一覧にリダイレクトされるか
        $response->assertRedirect('/tasks');

        // DBでis_completedがtrueに変わっているか
        $this->assertDatabaseHas('tasks', [
            'id'           => $task->id,
            'is_completed' => true, // 完了に切り替わっているはず
        ]);
    }
}