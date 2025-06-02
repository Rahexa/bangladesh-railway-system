<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainStatusController extends Controller
{
    public function getStatus(Request $request)
    {
        try {
            Log::info('TrainStatus Request', $request->all());
            $validated = $request->validate([
                'train_schedule_id' => 'required|exists:trainschedule,id',
                'date' => 'required|date',
            ]);

            $status = TrainStatus::with('trainSchedule')
                ->where('train_schedule_id', $validated['train_schedule_id'])
                ->where('date', $validated['date'])
                ->first();

            if (!$status) {
                return response()->json(['success' => false, 'message' => 'No tracking information available']);
            }

            return response()->json([
                'success' => true,
                'status' => [
                    'train_name' => $status->trainSchedule->train_name,
                    'from_station' => $status->trainSchedule->from_station,
                    'to_station' => $status->trainSchedule->to_station,
                    'current_station' => $status->current_station,
                    'status' => $status->status,
                    'last_updated' => $status->last_updated,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('TrainStatus Error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}