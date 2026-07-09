@extends('layouts.app')

@section('content')
    <h1>商品を追加</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div>
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>価格（円）</label>
            <input type="text" name="price" value="{{ old('price') }}">
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>在庫数</label>
            <input type="text" name="stock" value="{{ old('stock') }}">
            @error('stock')
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
            <label>説明</label>
            <textarea name="description" rows="8">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">追加する</button>
        <a href="{{ route('products.index') }}">← 戻る</a>
    </form>
@endsection