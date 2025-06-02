<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('payment_status', 'confirmed')->sum('total_amount');
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        $users = User::all();
        $bookings = Booking::all();

        return view('admin', compact(
            'totalUsers', 'totalBookings', 'totalRevenue',
            'confirmedBookings', 'pendingBookings', 'cancelledBookings',
            'users', 'bookings'
        ));
    }
}