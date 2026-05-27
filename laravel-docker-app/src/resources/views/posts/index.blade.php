@extends('layouts.app')

@section('content')
    <h1>投稿一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>カテゴリー</th>
                <th>作成日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </td>
                    <td>{{ $post->category }}</td>
                    <td>{{ $post->created_at->format('Y/m/d') }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}">編集</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">投稿がありません</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $posts->links() }}
    </div>
@endsection