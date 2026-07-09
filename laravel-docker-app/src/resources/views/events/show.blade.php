@extends('layouts.app')

@section('content')
    <h1>{{ $event->title }}</h1>

    <p><strong>開催日時：</strong>{{ \Carbon\Carbon::parse($event->event_date)->format('Y/m/d H:i') }}</p>

    <hr>

    <p>{{ $event->description }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('reservations.create', ['event_id' => $event->id]) }}" class="btn-primary">予約する</a>
        <a href="{{ route('events.index') }}">← 一覧に戻る</a>
    </div>

    <h2 style="margin-top: 30px;">予約一覧</h2>

    <table>
        <thead>
            <tr>
                <th>予約者名</th>
                <th>メール</th>
                <th>人数</th>
                <th>予約日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->email }}</td>
                    <td>{{ $reservation->number_of_people }}人</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->reserved_at)->format('Y/m/d H:i') }}</td>
                    <td>
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" onclick="return confirm('キャンセルしますか？')">キャンセル</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">予約がありません</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection