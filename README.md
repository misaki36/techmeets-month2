# Week 9: Repository/Service パターン リファクタリング

## 概要
Week 7・8 で作ったブログアプリを Repository/Service パターンでリファクタリングしました。
また、タスク管理アプリを最初から Repository/Service パターンで構築しました。

---

## Before / After 比較

### Before（Fat Controller）

```php
// PostController.php
public function index()
{
    // コントローラーが直接DBにアクセスしている
    $posts = Post::with('user')->latest()->get();
    return view('posts.index', compact('posts'));
}

public function edit(Post $post)
{
    // 認可チェックがコントローラーに直接書かれている
    // 同じチェックが edit・update・destroy の3箇所に重複している
    if (Auth::id() !== $post->user_id) {
        abort(403);
    }
    return view('posts.edit', compact('post'));
}
```

**問題点**
- コントローラーが DB 操作・認可チェック・レスポンスを全部担当している
- 同じ認可チェックが3箇所に重複している
- ロジックが散らばっていてテストしにくい

---

### After（Repository/Service パターン）

```php
// PostController.php
public function index()
{
    // Service に処理を任せるだけ
    $posts = $this->postService->getAllPosts();
    return view('posts.index', compact('posts'));
}

public function edit(Post $post)
{
    // Policy に認可チェックを任せるだけ（1行で済む）
    $this->authorize('update', $post);
    return view('posts.edit', compact('post'));
}
```

**改善点**
- コントローラーは「受け取って渡す」交通整理に専念
- 認可ルールは PostPolicy に一元管理
- DB操作は PostRepository に集約
- ビジネスロジックは PostService に集約

---

## 各層の役割

| 層 | クラス | 役割 |
|---|---|---|
| Controller | PostController | リクエストを受け取り、Service に渡すだけ |
| Service | PostService | ビジネスロジックを担当 |
| Repository | PostRepository | DB操作だけを担当 |
| Policy | PostPolicy | 認可ルールを一元管理 |

---

## 機能一覧

### ブログアプリ
- 投稿の一覧・作成・編集・削除
- 自分の投稿のみ編集・削除可能（Policy で制御）

### タスク管理アプリ
- タスクの一覧・作成・編集・削除
- タスクの完了/未完了の切り替え
- 自分のタスクのみ編集・削除・切り替え可能（Policy で制御）