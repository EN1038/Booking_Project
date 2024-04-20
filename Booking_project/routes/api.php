<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('Rooms', [AdminController::class, 'api_room'])->name('api_rooms');
Route::get('Historys', [AdminController::class, 'api_history'])->name('api_history');
Route::get('Line', [AdminController::class, 'api_line'])->name('api_line');
Route::get('Pie', [AdminController::class, 'api_pie'])->name('api_pie');
Route::get('typeRoom', [AdminController::class, 'api_typeRoom'])->name('api_typeRoom');
Route::get('bookingData', [AdminController::class, 'getBookingData']);
Route::get('bookingDatapie', [AdminController::class, 'getBookingDataPie']);
Route::get('count_status_booking_wait', [AdminController::class, 'count_status_booking_wait']);
