<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SeatAvailabilityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TrainListController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/user-profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/user-profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all')->middleware('auth');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password')->middleware('guest');
Route::post('/forgot-password/send', [AuthController::class, 'sendResetCode'])->name('forgot-password.send')->middleware(['guest', 'throttle:5,1']);
Route::get('/forgot-password/verify', [AuthController::class, 'showVerifyCodeForm'])->name('forgot-password.verify.form')->middleware('guest');
Route::post('/forgot-password/verify', [AuthController::class, 'verifyResetCode'])->name('forgot-password.verify')->middleware(['guest', 'throttle:5,1']);
Route::get('/password/reset/{email}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset')->middleware('guest');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset.post')->middleware(['guest', 'throttle:5,1']);

// Booking Routes
Route::get('/booking', [BookingController::class, 'create'])->name('booking');
Route::post('/booking/train-times', [BookingController::class, 'getTrainSchedules'])->name('booking.trainTimes');
Route::post('/booking/get-seat-availability', [BookingController::class, 'getSeatAvailability'])->name('booking.get-seat-availability');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy')->middleware('auth');
Route::post('/booking/check-ticket-limit', [BookingController::class, 'checkTicketLimit'])->name('booking.check-ticket-limit');
Route::post('/booking/send-otp', [BookingController::class, 'sendOtp'])->name('booking.send-otp');
Route::post('/booking/get-train-schedules', [App\Http\Controllers\BookingController::class, 'getTrainSchedules'])->name('booking.get-train-schedules');
Route::get('/booking/get-user-email', [BookingController::class, 'getUserEmail'])->name('booking.get-user-email');
// Seat Availability Routes (New Standalone Page)
Route::get('/seat-availability', function () {
    return view('seat-availability');
})->name('seat.availability');
Route::get('/api/train-schedules', [SeatAvailabilityController::class, 'getTrainSchedules'])->name('api.train-schedules');
Route::get('/api/coaches', [SeatAvailabilityController::class, 'getCoaches'])->name('api.coaches');
Route::post('/api/seat-availability', [SeatAvailabilityController::class, 'getSeatAvailability'])->name('api.seat-availability');

// Ticket Routes
Route::get('/ticket/{tranId}', [TicketController::class, 'show'])->name('ticket.show')->middleware('auth');
Route::get('/tickets', [BookingController::class, 'getUserTickets'])->name('tickets')->middleware('auth');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
});

// API-like Routes
Route::post('/api/seats/status', [SeatController::class, 'getSeatStatus'])->name('seats.status')->middleware('auth');
Route::post('/api/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate')->middleware('auth');

Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/trainlist', [TrainListController::class, 'index'])->name('trainlist');

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');
