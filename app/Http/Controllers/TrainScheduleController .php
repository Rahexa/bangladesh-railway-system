<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TrainSchedule;

class TrainScheduleController extends Controller
{
    // User-Side Method (from your existing code)
    public function getTrainSchedules(Request $request)
    {
        $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'date' => 'required|date',
        ]);

        $from = $request->input('from');
        $to = $request->input('to');

        $trains = DB::table('trainschedule')
            ->where('from_station', $from)
            ->where('to_station', $to)
            ->get();

        if ($trains->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No trains found for the selected route.']);
        }

        $trainSchedules = $trains->map(function ($train) {
            return [
                'departure_time' => $train->departure_time,
                'arrival_time' => $train->arrival_time,
                'train_type' => $train->train_type ?? 'Unknown'
            ];
        })->all();

        return response()->json(['success' => true, 'trainSchedules' => $trainSchedules]);
    }

    // Admin-Side Methods
    public function index()
    {
        return TrainSchedule::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'train_name' => 'required|string|max:50',
            'from_station' => 'required|string|max:50',
            'to_station' => 'required|string|max:50',
            'departure_time' => 'required|date_format:H:i:s',
            'arrival_time' => 'nullable|date_format:H:i:s'
        ]);
        return TrainSchedule::create($data);
    }

    public function show($id)
    {
        return TrainSchedule::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'train_name' => 'string|max:50',
            'from_station' => 'string|max:50',
            'to_station' => 'string|max:50',
            'departure_time' => 'date_format:H:i:s',
            'arrival_time' => 'nullable|date_format:H:i:s'
        ]);
        $train = TrainSchedule::findOrFail($id);
        $train->update($data);
        return $train;
    }

    public function destroy($id)
    {
        TrainSchedule::findOrFail($id)->delete();
        return response()->json(['message' => 'Train schedule deleted']);
    }
}