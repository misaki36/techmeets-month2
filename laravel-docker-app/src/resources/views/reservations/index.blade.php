@extends('layouts.app')

@section('content')
    <h1>予約一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>イベント名</th>
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
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->event->title }}</td>
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
                    <td colspan="7">予約がありません</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $reservations->links() }}
    </div>
@endsection