<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $table = 'seats';
    protected $fillable = ['train_schedule_id', 'coach_id', 'seat_number', 'date', 'status'];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_seats', 'seat_id', 'booking_id');
    }

    public function trainSchedule()
    {
        return $this->belongsTo(TrainSchedule::class, 'train_schedule_id');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class, 'coach_id');
    }
}