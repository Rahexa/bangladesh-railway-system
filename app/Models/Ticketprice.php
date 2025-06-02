<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    use HasFactory;

    // Assuming the price is stored in a 'ticket_prices' table
    protected $table = 'ticket_prices';

    protected $fillable = [
        'from_station', 'to_station', 'class', 'ticket_type', 'price'
    ];
}