<?php

namespace App\Http\Controllers;

use App\Models\TrainSchedule;
use App\Models\TicketPrice;
use Illuminate\Http\Request;

class TrainListController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainSchedule::query();

        // Apply filters
        if ($request->filled('from_station')) {
            $query->where('from_station', $request->from_station);
        }
        if ($request->filled('to_station')) {
            $query->where('to_station', $request->to_station);
        }
        if ($request->filled('date')) {
            $query->whereHas('seats', function ($q) use ($request) {
                $q->where('date', $request->date)->where('status', 'available');
            });
        }
        if ($request->filled('class')) {
            $query->whereNotNull(strtolower($request->class) . '_coaches');
        }

        $trains = $query->with('seats')->paginate(12);

        // Attach ticket prices to each train
        foreach ($trains as $train) {
            $train->price = TicketPrice::where('from_station', $train->from_station)
                ->where('to_station', $train->to_station)
                ->first();
        }

        // Get unique stations and classes for filter dropdowns
        $stations = TrainSchedule::select('from_station')
            ->distinct()
            ->pluck('from_station')
            ->merge(TrainSchedule::select('to_station')->distinct()->pluck('to_station'))
            ->unique()
            ->sort();
        $classes = ['AC_B', 'AC_S', 'SNIGDHA', 'F_BERTH', 'F_SEAT', 'S_CHAIR', 'SHOVAN', 'SHULOV'];

        return view('trainlist', compact('trains', 'stations', 'classes'));
    }
}