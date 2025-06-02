<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'train_schedule_id',
        'train_name',
        'from',
        'to',
        'class',
        'ticket_type',
        'number_of_tickets',
        'contact_no',
        'name',
        'age',
        'date',
        'journey_type',
        'departure_time',
        'arrival_time',
        'national_id',
        'selected_seats', // Keep only one instance
        'coach',
        'transaction_id',
        'total_amount',
        'payment_status',
        'status',
        'bank_tran_id',
        'card_type',
        'gateway_response',
        'session_key',
        'payment_token',
    ];

    protected $casts = [
        'selected_seats' => 'array',
    ];

    // Add the seats relationship
    public function seats()
    {
        return $this->hasMany(BookingSeat::class, 'booking_id', 'id');
    }
}