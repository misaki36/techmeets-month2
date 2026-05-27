@extends('layouts.app')

@section('content')
    <h1>イベント一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>開催日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('Y/m/d H:i') }}</td>
                    <td>
                        <a href="{{ route('reservations.create', ['event_id' => $event->id]) }}">予約する</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">イベントがありません</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $events->links() }}
    </div>
@endsection