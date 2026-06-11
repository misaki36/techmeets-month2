<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

// リクエストを受け取って、ServiceやRepositoryに処理を任せるだけのクラス
// コントローラーは「交通整理」に専念する
class PostController extends Controller
{
    // LaravelがPostServiceとPostRepositoryを自動で渡してくれる（依存性注入）
    public function __construct(
        private PostService $postService,
        private PostRepository $postRepository
    ) {}

    // 投稿一覧を表示
    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('posts.index', compact('posts'));
    }

    // 投稿作成フォームを表示
    public function create()
    {
        return view('posts.create');
    }

    // 投稿を保存
    public function store(Request $request)
    {
        // 入力値のバリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // ログイン中のユーザーIDを追加
        $validated['user_id'] = auth()->id();

        // Serviceに投稿作成を依頼
        $this->postService->createPost($validated);

        return redirect()->route('posts.index')->with('success', '投稿しました！');
    }

    // 投稿の詳細を表示
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // 投稿編集フォームを表示
    public function edit(Post $post)
    {
        // 本人以外はアクセス不可（PostPolicyのupdateメソッドで判定）
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    // 投稿を更新
    public function update(Request $request, Post $post)
    {
        // 本人以外はアクセス不可（PostPolicyのupdateメソッドで判定）
        $this->authorize('update', $post);

        // 入力値のバリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // Serviceに更新を依頼
        $this->postService->updatePost($post, $validated);

        return redirect()->route('posts.index')->with('success', '更新しました！');
    }

    // 投稿を削除
    public function destroy(Post $post)
    {
        // 本人以外はアクセス不可（PostPolicyのdeleteメソッドで判定）
        $this->authorize('delete', $post);

        // Serviceに削除を依頼
        $this->postService->deletePost($post);

        return redirect()->route('posts.index')->with('success', '削除しました！');
    }
}