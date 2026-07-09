@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>

    <p><strong>価格：</strong>¥{{ number_format($product->price) }}</p>
    <p><strong>在庫数：</strong>{{ $product->stock }}</p>
    <p><strong>カテゴリー：</strong>{{ $product->category }}</p>

    <hr>

    <p>{{ $product->description }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('products.edit', $product) }}" class="btn-primary">編集</a>
        <a href="{{ route('products.index') }}">← 一覧に戻る</a>
    </div>
@endsection