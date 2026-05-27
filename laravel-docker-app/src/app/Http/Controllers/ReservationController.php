<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // 予約一覧
    public function index()
    {
        $reservations = Reservation::with('event')->latest()->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    // 予約フォーム表示
    public function create(Request $request)
    {
        $event = Event::findOrFail($request->event_id);
        return view('reservations.create', compact('event'));
    }

    // 予約作成処理
    public function store(Request $request)
    {
        $request->validate([
            'event_id'         => 'required|exists:events,id',
            'name'             => 'required|max:255',
            'email'            => 'required|email',
            'number_of_people' => 'required|integer|min:1',
            'reserved_at'      => 'required|date',
        ]);

        Reservation::create($request->only(
            'event_id', 'name', 'email', 'number_of_people', 'reserved_at'
        ));

        return redirect()->route('reservations.index')->with('success', '予約しました！');
    }

    // 予約キャンセル
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', '予約をキャンセルしました！');
    }

    // 使わないメソッド
    public function show(Reservation $reservation) {}
    public function edit(Reservation $reservation) {}
    public function update(Request $request, Reservation $reservation) {}
}