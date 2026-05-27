<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 一覧表示
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index', compact('posts'));
    }

    // 詳細表示
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // 作成フォーム表示
    public function create()
    {
        return view('posts.create');
    }

    // 作成処理
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'category' => 'required|max:100',
        ]);

        Post::create($request->only('title', 'content', 'category'));

        return redirect()->route('posts.index')->with('success', '投稿を作成しました！');
    }

    // 編集フォーム表示
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // 編集処理
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'category' => 'required|max:100',
        ]);

        $post->update($request->only('title', 'content', 'category'));

        return redirect()->route('posts.index')->with('success', '投稿を更新しました！');
    }

    // 削除処理
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿を削除しました！');
    }
}