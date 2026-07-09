<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
    ];

    // このイベントの予約一覧を取得
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
