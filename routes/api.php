<?php
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrainScheduleController;
use App\Http\Controllers\Api\TrainStatusController;

Route::post('/payment/success/{tranId}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/success/{tranId}', [PaymentController::class, 'success'])->name('api.payment.success');
Route::match(['get', 'post'], '/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate')->middleware('auth');



Route::get('/train-schedules', [TrainScheduleController::class, 'index'])->name('api.train-schedules');
Route::post('/train-status', [TrainStatusController::class, 'getStatus'])->name('api.train-status');

