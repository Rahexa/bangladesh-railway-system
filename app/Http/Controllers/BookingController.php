<?php

namespace App\Http\Controllers;
use App\Models\BookingSeat;
use App\Models\Booking;
use App\Models\TrainSchedule;
use App\Models\Seat;
use App\Models\Coach;
use App\Models\TicketPrice;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        return view('booking');
    }

    public function getTrainSchedules(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');

        if (!$from || !$to || !$date) {
            return response()->json(['success' => false, 'message' => 'Please provide from, to, and date.']);
        }

        if ($from === $to) {
            return response()->json(['success' => false, 'message' => 'Departure and arrival stations cannot be the same.']);
        }

        $trainSchedules = TrainSchedule::where('from_station', $from)
            ->where('to_station', $to)
            ->get();

        return response()->json(['success' => true, 'trainSchedules' => $trainSchedules]);
    }

    public function getSeatAvailability(Request $request)
    {
        $validated = $request->validate([
            'train_schedule_id' => 'required|integer|exists:trainschedule,id',
            'class' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'date' => 'required|date',
            'number_of_tickets' => 'required|integer|min:1',
        ]);

        $train_schedule_id = $request->input('train_schedule_id');
        $class = $request->input('class');
        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');

        $coaches = Coach::where('class_name', $class)
            ->select('id', 'coach_name', 'class_name', 'total_seats')
            ->get()
            ->map(function ($coach) use ($train_schedule_id, $date) {
                $booked_seats = Seat::where('train_schedule_id', $train_schedule_id)
                    ->where('coach_id', $coach->id)
                    ->where('date', $date)
                    ->where('status', 'booked')
                    ->count();

                $available_seats = $coach->total_seats - $booked_seats;

                return [
                    'coach_name' => $coach->coach_name,
                    'class_name' => $coach->class_name,
                    'available_seats' => $available_seats,
                    'total_seats' => $coach->total_seats,
                ];
            })
            ->toArray();

        $ticketPrice = TicketPrice::where('from_station', $from)
            ->where('to_station', $to)
            ->first();

        if (!$ticketPrice) {
            return response()->json([
                'success' => false,
                'message' => 'No ticket prices found for this route.'
            ], 404);
        }

        $ticketPrices = [
            'AC_B' => $ticketPrice->AC_B,
            'AC_S' => $ticketPrice->AC_S,
            'SNIGDHA' => $ticketPrice->SNIGDHA,
            'F_BERTH' => $ticketPrice->F_BERTH,
            'F_SEAT' => $ticketPrice->F_SEAT,
            'S_CHAIR' => $ticketPrice->S_CHAIR,
            'SHOVAN' => $ticketPrice->SHOVAN,
            'SHULOV' => $ticketPrice->SHULOV,
        ];

        return response()->json([
            'success' => true,
            'coaches' => $coaches,
            'ticketPrice' => $ticketPrices,
        ]);
    }

    public function checkTicketLimit(Request $request)
    {
        $number_of_tickets = $request->input('number_of_tickets');
        $date = $request->input('date');

        if (!$number_of_tickets || !$date) {
            return response()->json(['success' => false, 'message' => 'Number of tickets and date are required.'], 400);
        }

       

        $user = Auth::user();
        if ($user) {
            $bookings = Booking::where('user_id', $user->id)
                ->where('date', $date)
                ->sum('number_of_tickets');

            if ($bookings + $number_of_tickets > 4) {
                return response()->json(['success' => false, 'message' => 'You have exceeded the ticket limit of 4 for this date.'], 403);
            }
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'from' => 'required|string|max:255',
                'to' => 'required|string|max:255',
                'date' => 'required|date|after_or_equal:today',
                'journey_type' => 'required|in:oneWay,roundTrip',
                'train_schedule_id' => 'required|integer|exists:trainschedule,id',
                'class' => 'required|in:AC_B,AC_S,SNIGDHA,F_BERTH,F_SEAT,S_CHAIR,SHOVAN,SHULOV',
                'ticket_type' => 'required|in:adult,child',
                'number_of_tickets' => 'required|integer|min:1|max:4',
                'contact_no' => 'required|string|max:20',
                'name' => 'required|string|max:255',
                'age' => 'required|integer|min:1|max:120',
                'national_id' => 'required|string|max:50',
                'coach' => 'required|string|max:255',
                'selected_seats' => 'required|array|min:1',
                'selected_seats.*' => 'string|max:20',
                'amount' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first(),
                ], 422);
            }

            $user = Auth::user();
            $existingTickets = Booking::where('user_id', $user->id)
                ->where('date', $request->date)
                ->sum('number_of_tickets');

            if ($existingTickets + $request->number_of_tickets > 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have exceeded the ticket limit of 4 for this date.',
                ], 403);
            }

            $trainSchedule = TrainSchedule::find($request->train_schedule_id);
            if (!$trainSchedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid train schedule ID.',
                ], 404);
            }

            $selectedSeats = $request->selected_seats;
            $seatCount = count($selectedSeats);
            if ($seatCount != $request->number_of_tickets) {
                return response()->json([
                    'success' => false,
                    'message' => "Selected seats count ($seatCount) does not match number of tickets ($request->number_of_tickets).",
                ], 422);
            }

            $unavailableSeats = Seat::whereIn('seat_number', $selectedSeats)
                ->where('train_schedule_id', $request->train_schedule_id)
                ->where('date', $request->date)
                ->where('status', '!=', 'available')
                ->pluck('seat_number')
                ->toArray();

            if (!empty($unavailableSeats)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some seats are not available: ' . implode(', ', $unavailableSeats),
                ], 422);
            }

            $ticketPrice = TicketPrice::where('from_station', $request->from)
                ->where('to_station', $request->to)
                ->first();

            if (!$ticketPrice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket price not found for this route.',
                ], 404);
            }

            $pricePerTicket = $ticketPrice->{$request->class};
            $totalAmount = $pricePerTicket * $request->number_of_tickets;

            DB::beginTransaction();

            $booking = Booking::create([
                'user_id' => $user->id,
                'train_name' => $trainSchedule->train_name,
                'train_schedule_id' => $request->train_schedule_id,
                'from' => $request->from,
                'to' => $request->to,
                'class' => $request->class,
                'ticket_type' => $request->ticket_type,
                'number_of_tickets' => $request->number_of_tickets,
                'contact_no' => $request->contact_no,
                'name' => $request->name,
                'age' => $request->age,
                'date' => $request->date,
                'journey_type' => $request->journey_type,
                'departure_time' => $trainSchedule->departure_time,
                'arrival_time' => $trainSchedule->arrival_time,
                'national_id' => $request->national_id,
                'coach' => $request->coach,
                'total_amount' => $totalAmount,
                'selected_seats' => json_encode($selectedSeats),
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            Seat::whereIn('seat_number', $selectedSeats)
                ->where('train_schedule_id', $request->train_schedule_id)
                ->where('date', $request->date)
                ->update(['status' => 'reserved']);

            foreach ($selectedSeats as $seatNumber) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'seat_number' => $seatNumber,
                    'amount' => $pricePerTicket,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully.',
                'booking_id' => $booking->id,
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Database error in BookingController::store: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in BookingController::store: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the booking.',
            ], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $otp = $request->input('otp');
            $user = Auth::user();

            if (!$user || !$user->email) {
                Log::error('OTP sending failed: No authenticated user or email address.', ['user_id' => Auth::id()]);
                return response()->json([
                    'success' => false,
                    'message' => 'No authenticated user or email address found.'
                ], 400);
            }

            if (!$otp) {
                Log::error('OTP sending failed: No OTP provided.', ['user_id' => Auth::id()]);
                return response()->json([
                    'success' => false,
                    'message' => 'OTP is required.'
                ], 400);
            }

            Mail::to($user->email)->send(new OtpMail($otp));
            Log::info('OTP email sent successfully.', ['user_id' => Auth::id(), 'email' => $user->email, 'otp' => $otp]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to your email.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email.', [
                'user_id' => Auth::id(),
                'email' => $user->email ?? 'N/A',
                'otp' => $otp ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUserEmail(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        if (!$user->email) {
            return response()->json([
                'success' => false,
                'message' => 'No email address found for this user.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'email' => $user->email
        ]);
    }

    public function seatStatus(Request $request)
    {
        $train_schedule_id = $request->input('train_schedule_id');
        $coach_name = $request->input('coach_name');
        $date = $request->input('date');
        $from = $request->input('from');
        $to = $request->input('to');

        if (!$train_schedule_id || !$coach_name || !$date || !$from || !$to) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required parameters.'
            ], 400);
        }

        $seats = Seat::where('train_schedule_id', $train_schedule_id)
            ->where('date', $date)
            ->whereHas('coach', function ($query) use ($coach_name) {
                $query->where('coach_name', $coach_name);
            })
            ->select('seat_number', 'status')
            ->get()
            ->map(function ($seat) {
                return [
                    'seat_number' => $seat->seat_number,
                    'status' => $seat->status
                ];
            })
            ->toArray();

        return response()->json([
            'success' => true,
            'seats' => $seats
        ]);
    }

    public function showTickets()
    {
        $user = Auth::user();

        if (!$user) {
            return view('tickets', ['message' => 'Please log in to view your tickets.']);
        }

        $bookings = Booking::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        if ($bookings->isEmpty()) {
            return view('tickets', ['message' => 'No tickets found.']);
        }

        return view('tickets', compact('bookings'));
    }

    public function getUserTickets()
    {
        $user = Auth::user();

        if (!$user) {
            return view('tickets', ['message' => 'Please log in to view your tickets.']);
        }

        $bookings = Booking::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        if ($bookings->isEmpty()) {
            return view('tickets', ['message' => 'No tickets found.']);
        }

        return view('tickets', compact('bookings'));
    }
}