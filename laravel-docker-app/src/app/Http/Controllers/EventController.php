<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // 一覧表示
    public function index()
    {
        $events = Event::latest()->paginate(5);
        return view('events.index', compact('events'));
    }

    // 詳細表示
    public function show(Event $event)
    {
        $reservations = $event->reservations()->latest()->get();
        return view('events.show', compact('event', 'reservations'));
    }

    // 作成フォーム表示
    public function create()
    {
        return view('events.create');
    }

    // 作成処理
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'event_date'  => 'required|date',
        ]);

        Event::create($request->only('title', 'description', 'event_date'));

        return redirect()->route('events.index')->with('success', 'イベントを作成しました！');
    }

    // 使わないメソッドはそのまま
    public function edit(Event $event)
    {
    }
    public function update(Request $request, Event $event)
    {
    }
    public function destroy(Event $event)
    {
    }
}
