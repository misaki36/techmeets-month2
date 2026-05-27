@extends('layouts.app')

@section('content')
    <h1>新規投稿</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div>
            <label>タイトル</label>
            <input type="text" name="title" value="{{ old('title') }}">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>カテゴリー</label>
            <input type="text" name="category" value="{{ old('category') }}">
            @error('category')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>内容</label>
            <textarea name="content" rows="8">{{ old('content') }}</textarea>
            @error('content')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">投稿する</button>
        <a href="{{ route('posts.index') }}">← 戻る</a>
    </form>
@endsection