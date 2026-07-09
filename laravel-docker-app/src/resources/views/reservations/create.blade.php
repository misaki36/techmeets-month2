@extends('layouts.app')

@section('content')
    <h1>「{{ $event->title }}」を予約する</h1>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <div>
            <label>お名前</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>メールアドレス</label>
            <input type="text" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>人数</label>
            <input type="text" name="number_of_people" value="{{ old('number_of_people') }}">
            @error('number_of_people')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>予約日時</label>
            <input type="datetime-local" name="reserved_at" value="{{ old('reserved_at') }}">
            @error('reserved_at')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">予約する</button>
        <a href="{{ route('events.index') }}">← 戻る</a>
    </form>
@endsection