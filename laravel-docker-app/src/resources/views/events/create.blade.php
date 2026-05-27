@extends('layouts.app')

@section('content')
    <h1>イベントを追加</h1>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div>
            <label>タイトル</label>
            <input type="text" name="title" value="{{ old('title') }}">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>開催日時</label>
            <input type="datetime-local" name="event_date" value="{{ old('event_date') }}">
            @error('event_date')
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
        <a href="{{ route('events.index') }}">← 戻る</a>
    </form>
@endsection