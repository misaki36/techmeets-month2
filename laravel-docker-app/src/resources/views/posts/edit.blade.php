@extends('layouts.app')

@section('content')
    <h1>投稿を編集</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>タイトル</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>カテゴリー</label>
            <input type="text" name="category" value="{{ old('category', $post->category) }}">
            @error('category')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>内容</label>
            <textarea name="content" rows="8">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">更新する</button>
        <a href="{{ route('posts.index') }}">← 戻る</a>
    </form>
@endsection
