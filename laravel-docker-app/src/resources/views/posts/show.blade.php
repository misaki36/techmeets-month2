@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>

    <p><strong>カテゴリー：</strong>{{ $post->category }}</p>
    <p><strong>投稿日：</strong>{{ $post->created_at->format('Y/m/d H:i') }}</p>

    <hr>

    <p>{{ $post->content }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('posts.edit', $post) }}" class="btn-primary">編集</a>
        <a href="{{ route('posts.index') }}">← 一覧に戻る</a>
    </div>
@endsection