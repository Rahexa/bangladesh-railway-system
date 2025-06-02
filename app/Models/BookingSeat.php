<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    protected $table = 'booking_seats';

    protected $fillable = [
        'booking_id',
        'seat_number',
        'amount',
        'created_at',
        'updated_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}