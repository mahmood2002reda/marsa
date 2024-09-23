<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
  
        Route::post('/set-locale', [TourController::class, 'setLocale']);
        Route::get('/get-locale', [TourController::class, 'getLocale'])->name('dash');
   
});


// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// User routes (Protected by Sanctum middleware)
Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('information', [UserController::class, 'ueserInfo']);
    Route::post('update', [UserController::class, 'update']);
});

// Tour routes
Route::group(['prefix' => 'tours', 'middleware' => 'auth:sanctum'], function () {
    Route::get('search', [TourController::class, 'searchTours'])->name('tours.search');

    Route::get('/', [TourController::class, 'index'])->name('tours.index');
    Route::get('create', [TourController::class, 'create'])->name('tours.create')->withoutMiddleware('auth:sanctum');
    Route::post('/', [TourController::class, 'store'])->name('store');
    Route::get('{id}', [TourController::class, 'show'])->name('tours.show');
    Route::get('{id}/make-offer', [TourController::class, 'MakeOffer']);
    Route::get('type/{type}', [TourController::class, 'getToursByType'])->name('api.tours.byType');
    Route::get('type/{type}/governorate/{governorate}', [TourController::class, 'getToursByTypeAndGovernorate']);

});

// Offer routes
Route::prefix('offers')->group(function () {
    Route::get('/', [OfferController::class, 'AllOffers']);
    Route::post('{id}', [OfferController::class, 'OfferUpdate']);
});

// Reservation routes
Route::prefix('reservations')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ReservationController::class, 'MyReservation']);
    Route::post('add', [ReservationController::class, 'createReservation']);
    Route::get('my-reservations/pdf', [ReservationController::class, 'generatePdf']);
});






Route::post('{id}/payment', [ReservationController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/form/{id}', [ReservationController::class, 'showPaymentForm'])->name('payment.form');
