<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainStatus extends Model
{
    use HasFactory;

    protected $table = 'trainstatus';

    protected $fillable = [
        'train_schedule_id',
        'date',
        'current_station',
        'status',
        'last_updated',
    ];

    public function trainSchedule()
    {
        return $this->belongsTo(TrainSchedule::class, 'train_schedule_id');
    }
}