<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TourController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/marsa', function () {
    return view('index');
});
Route::post('tours/store', [TourController::class, 'store'])->name('tours.store');
Route::get('/tours/{id}', [TourController::class, 'show'])->name('tours.show');
Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [TourController::class, 'index'])->name('home');
Route::patch('/fcm-token', [TourController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification',[TourController::class,'notification'])->name('notification');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
use App\Http\Controllers\FCMController;

Route::get('/api/store-fcm-token', [FCMController::class, 'storeToken']);
Route::view('fcm','fcmToken');

Route::get('/types', [TourController::class, 'getTypes'])->name('types');

// جلب الرحلات حسب النوع
Route::get('/tours/type/{type}', [TourController::class, 'getToursByType'])->name('tours.byType');

// جلب الرحلات حسب النوع والمنطقة
//Route::get('/tours/type/{type}/governorate/{governorate}', [TourController::class, 'getToursByTypeAndGovernorate'])->name('tours.byTypeAndGovernorate');


Route::group(['prefix' => 'tours'], function () {
    Route::get('/', [TourController::class, 'index'])->name('tours.index'); // Show all tours
    Route::get('/new/create', [TourController::class, 'create'])->name('tours.create'); // Show create form
    Route::post('/', [TourController::class, 'store'])->name('tours.store'); // Store new tour
    Route::get('/{id}', [TourController::class, 'show'])->name('tours.show'); // Show single tour
});


