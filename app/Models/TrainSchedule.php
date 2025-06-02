<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainSchedule extends Model
{
    protected $table = 'trainschedule';

    protected $fillable = [
        'train_name',
        'train_type',
        'arrival_time',
        'departure_time',
        'from_station',
        'to_station',
        'AC_B_coaches',
        'AC_S_coaches',
        'SNIGDHA_coaches',
        'F_BERTH_coaches',
        'F_SEAT_coaches',
        'S_CHAIR_coaches',
        'SHOVAN_coaches',
        'SHULOV_coaches',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'train_schedule_id');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'train_schedule_id');
    }
}