<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'email',
        'number_of_people',
        'reserved_at',
    ];

    // この予約がどのイベントか取得
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
