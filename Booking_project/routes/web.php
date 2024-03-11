<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::get('DashBoard_Admin', [AdminController::class,'dashBoard_admin'])->name('dashboard_admin');
Route::get('Create_Rooms',[AdminController::class,'create_room'])->name('create_room');
Route::get('Create_TypeRooms',[AdminController::class,'create_typeroom'])->name('create_typeroom');
Route::post('insert_type_rooms', [AdminController::class,'insert_typeroom'])->name('insert_typeroom');
Route::get('delete_type_room/{id}',[AdminController::class,'delete_type_rooms'])->name('delete_type_rooms');