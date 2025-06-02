<?php

namespace Database\Seeders;

use App\Models\TrainSchedule;
use App\Models\TrainStatus;
use Illuminate\Database\Seeder;

class TrainStatusSeeder extends Seeder
{
    public function run(): void
    {
        $train = TrainSchedule::create([
            'train_name' => 'Dhaka Express',
            'train_type' => 'Express',
            'from_station' => 'Dhaka Junction',
            'to_station' => 'Chittagong Central',
            'departure_time' => '08:00:00',
            'arrival_time' => '14:30:00',
            'AC_B_coaches' => 2,
        ]);

        TrainStatus::create([
            'train_schedule_id' => $train->id,
            'date' => '2025-05-02',
            'current_station' => 'Comilla',
            'status' => 'On Time',
            'last_updated' => now(),
        ]);
    }
}