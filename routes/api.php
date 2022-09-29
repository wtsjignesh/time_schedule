<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ScheduleConfigratoinController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/get-schedule-configrations', [ScheduleConfigratoinController::class, 'getScheduleConfigratoin']);
Route::post('/store-booking', [BookingController::class, 'storeBooking']);