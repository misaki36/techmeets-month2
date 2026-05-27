<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログシステム</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        nav { margin-bottom: 20px; padding: 10px; background: #f0f0f0; }
        nav a { margin-right: 15px; text-decoration: none; color: #333; }
        .success { color: green; background: #e0ffe0; padding: 10px; margin-bottom: 15px; }
        .error { color: red; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        input[type=text], input[type=datetime-local], textarea, select { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button, .btn { padding: 8px 16px; cursor: pointer; }
        .btn-danger { background: red; color: white; border: none; }
        .btn-primary { background: blue; color: white; border: none; text-decoration: none; padding: 8px 16px; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('posts.index') }}">📝 ブログ一覧</a>
        <a href="{{ route('posts.create') }}">➕ 新規投稿</a>
        　|　
        <a href="{{ route('products.index') }}">📦 商品一覧</a>
        <a href="{{ route('products.create') }}">➕ 商品追加</a>
        　|　
        <a href="{{ route('events.index') }}">🎫 イベント一覧</a>
        <a href="{{ route('events.create') }}">➕ イベント追加</a>
        　|　
        <a href="{{ route('reservations.index') }}">📋 予約一覧</a>
    </nav>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @yield('content')
</body>
</html>