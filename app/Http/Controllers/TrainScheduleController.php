<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainSchedule;

class TrainScheduleController extends Controller
{
    public function index()
    {
        return TrainSchedule::select('id', 'train_name', 'from_station', 'to_station')->get();
    }
}