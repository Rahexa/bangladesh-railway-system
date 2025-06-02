<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $bookings = Booking::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Bookings debug', [
            'user_id' => $user->id,
            'booking_count' => $bookings->count(),
            'bookings' => $bookings->toArray()
        ]);

        if ($bookings->isEmpty()) {
            Log::info('No bookings found for user', ['user_id' => $user->id]);
            return view('ticket', ['message' => 'No recent booking found. Please make a booking first.']);
        }

        return view('ticket', compact('bookings'));
    }

    public function show($tranId)
    {
        $user = Auth::user();

        $bookings = Booking::with('seats')
            ->where('user_id', $user->id)
            ->whereIn('transaction_id', function ($query) use ($tranId, $user) {
                $query->select('transaction_id')
                    ->from('bookings')
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(4);
            })
            ->get();

        if ($bookings->isEmpty()) {
            Log::info('No bookings found for user', ['tranId' => $tranId, 'user_id' => $user->id]);
            return view('ticket', ['message' => 'No recent booking found. Please make a booking first.']);
        }

        $bookings = $bookings->sortBy(function ($booking) use ($tranId) {
            return $booking->transaction_id === $tranId ? 0 : 1;
        })->take(4);

        Log::info('Ticket view accessed', [
            'tranId' => $tranId,
            'user_id' => $user->id,
            'booking_count' => $bookings->count(),
            'booking_ids' => $bookings->pluck('id')->toArray(),
            'seats' => $bookings->map(fn($b) => $b->selected_seats)->toArray()
        ]);

        return view('ticket', compact('bookings'));
    }
}