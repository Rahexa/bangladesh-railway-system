<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainSchedule;
use App\Models\Coach;
use App\Models\Seat;

class SeatAvailabilityController extends Controller
{
    public function getTrainSchedules()
    {
        $schedules = TrainSchedule::select('id', 'train_name', 'from_station', 'to_station')->get();
        return response()->json($schedules);
    }

    public function getCoaches()
    {
        $coaches = Coach::select('coach_name', 'class_name')->get();
        return response()->json($coaches);
    }

    public function getSeatAvailability(Request $request)
    {
        $request->validate([
            'train_schedule_id' => 'required|exists:trainschedule,id',
            'coach_name' => 'required|string|max:20',
            'date' => 'required|date',
        ]);

        $trainScheduleId = $request->input('train_schedule_id');
        $coachName = $request->input('coach_name');
        $date = $request->input('date');

        $coach = Coach::where('coach_name', $coachName)->first();
        if (!$coach) {
            \Log::error("Coach not found: $coachName");
            return response()->json(['success' => false, 'message' => 'Coach not found'], 404);
        }

        $seats = Seat::where('train_schedule_id', $trainScheduleId)
            ->where('coach_id', $coach->id)
            ->where('date', $date)
            ->select('seat_number', 'status')
            ->get();

        \Log::info("Seat query: ", ['train_schedule_id' => $trainScheduleId, 'coach_id' => $coach->id, 'date' => $date, 'seats' => $seats->toArray()]);

        if ($seats->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No seats available for this selection']);
        }

        return response()->json(['success' => true, 'seats' => $seats]);
    }
}