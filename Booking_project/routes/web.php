<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelUserController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['check.role']], function () {
    // System Admin //
    //DashBoard_Admin
    Route::get('DashBoard_Admin', [AdminController::class, 'dashBoard_admin'])->name('dashboard_admin');
    //Room_Admin
    Route::get('Create_Rooms', [AdminController::class, 'create_room'])->name('create_room');
    Route::post('Insert_Rooms', [AdminController::class, 'insert_room'])->name('insert_room');
    Route::get('Delete_rooms/{id}', [AdminController::class, 'delete_room'])->name('delete_room');
    Route::get('Delete_listrooms/{id}', [AdminController::class, 'delete_listroom'])->name('delete_listroom');
    Route::get('Change_status/{id}', [AdminController::class, 'change_status'])->name('change_status');
    Route::get('listRoom/{id}', [AdminController::class, 'view_listroom'])->name('view_listroom');
    Route::post('update/{id}', [AdminController::class, 'update_room'])->name('update_room');
    //status_room
    Route::get('Status_room', [AdminController::class, 'status_room'])->name('status_room');
    Route::get('Update_status_admin/{id}/{value}', [AdminController::class, 'update_status_admin'])->name('update_status_admin');
    //History_Room
    Route::get('History_room', [AdminController::class, 'history_room'])->name('history_room');
    //Type_Room
    Route::get('Create_TypeRooms', [AdminController::class, 'create_typeroom'])->name('create_typeroom');
    Route::post('Insert_type_rooms', [AdminController::class, 'insert_typeroom'])->name('insert_typeroom');
    Route::get('Delete_type_room/{id}', [AdminController::class, 'delete_type_rooms'])->name('delete_type_rooms');
    Route::post('Edit_type_room/{id}', [AdminController::class, 'edit_type_rooms'])->name('edit_type_rooms');
});

Route::post('Booking_Rooms', [UserController::class, 'booking_rooms'])->name('booking_rooms');
Route::get('Update_status_user/{id}/{value}', [UserController::class, 'update_status_user'])->name('update_status_user');
Route::get('View_Status/{id}', [UserController::class, 'statusRoom'])->name('statusRoom');
Route::get('History/{id}', [UserController::class, 'history'])->name('history');


//Login
Route::get('Login', [LevelUserController::class, 'login'])->name('login');
Route::get('Register', [LevelUserController::class, 'register'])->name('register');
Route::post('Insert_register', [LevelUserController::class, 'insert_register'])->name('insert_register');
Route::post('Insert_login', [LevelUserController::class, 'Authlogin'])->name('insert_login');
Route::get('Logout', [LevelUserController::class, 'logout'])->name('logout');

//User
Route::get('DashBoard_User', [UserController::class, 'dashboardUser'])->name('dashboard_user');
