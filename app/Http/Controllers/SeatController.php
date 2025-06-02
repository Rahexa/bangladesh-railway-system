<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainSchedule;
use App\Models\Coach;
use App\Models\Seat;
use App\Models\Booking;

class SeatController extends Controller
{
    public function getSeatStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'train_schedule_id' => 'required|exists:trainschedule,id',
            'coach_name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $trainSchedule = TrainSchedule::find($request->train_schedule_id);
        if (!$trainSchedule) {
            return response()->json(['success' => false, 'message' => 'Invalid train schedule'], 404);
        }

        $coach = Coach::where('coach_name', $request->coach_name)->first();
        if (!$coach) {
            return response()->json(['success' => false, 'message' => 'Invalid coach'], 404);
        }

        // Fetch seat statuses from the seats table
        $seats = Seat::where('train_schedule_id', $request->train_schedule_id)
            ->where('coach_id', $coach->id)
            ->where('date', $request->date)
            ->get(['seat_number', 'status'])
            ->map(function ($seat) {
                return [
                    'seat_number' => $seat->seat_number,
                    'status' => $seat->status,
                ];
            });

        // If no seat records exist, generate seat statuses based on coach capacity
        if ($seats->isEmpty()) {
            $totalSeats = $coach->total_seats;
            $seats = collect();
            for ($i = 1; $i <= $totalSeats; $i++) {
                $seatNumber = "{$coach->coach_name}-{$i}";
                $seats->push([
                    'seat_number' => $seatNumber,
                    'status' => 'available',
                ]);
            }
        }

        // Cross-check with bookings to ensure booked seats are marked
        $bookedSeats = Booking::where('train_schedule_id', $request->train_schedule_id)
            ->where('coach', $request->coach_name)
            ->where('date', $request->date)
            ->whereIn('payment_status', ['confirmed', 'pending'])
            ->get()
            ->flatMap(function ($booking) {
                return json_decode($booking->selected_seats, true);
            })->unique();

        // Update seat statuses to 'booked' for seats in active bookings
        $seats = $seats->map(function ($seat) use ($bookedSeats) {
            if ($bookedSeats->contains($seat['seat_number'])) {
                $seat['status'] = 'booked';
            }
            return $seat;
        });

        return response()->json([
            'success' => true,
            'seats' => $seats->values(),
        ]);
    }
}