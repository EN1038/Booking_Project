<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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



Route::group(['middleware' => ['check.role']], function () {
    // System Admin //
    //DashBoard_Admin
    Route::get('DashBoard_Admin', [AdminController::class, 'dashBoard_admin'])->name('dashboard_admin');
    Route::get('All_change_status', [AdminController::class, 'all_change_status'])->name('all_change_status');
    //Room_Admin
    Route::get('Create_Rooms', [AdminController::class, 'create_room'])->name('create_room');
    Route::post('Insert_Rooms', [AdminController::class, 'insert_room'])->name('insert_room');
    Route::get('Delete_rooms/{id}', [AdminController::class, 'delete_room'])->name('delete_room');
    Route::get('Delete_listrooms/{id}', [AdminController::class, 'delete_listroom'])->name('delete_listroom');
    Route::get('Change_status/{id}', [AdminController::class, 'change_status'])->name('change_status');
    Route::get('listRoom/{id}', [AdminController::class, 'view_listroom'])->name('view_listroom');
    Route::post('update/{id}', [AdminController::class, 'update_room'])->name('update_room');
    Route::get('update_wt/{id}', [AdminController::class, 'update_wt'])->name('update_wt');
    Route::get('change_leveluser', [AdminController::class, 'change_leveluser'])->name('change_leveluser');
    Route::post('change_level_user', [AdminController::class, 'change_level_user'])->name('change_level_user');
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
    //Bookin_admin
    Route::get('Booking_Admin', [AdminController::class, 'booking_admin'])->name('booking_admin');
    Route::post('insert_BookinAdmin', [AdminController::class, 'insert_booking_admin'])->name('insert_booking_admin');
});




//Login
// Route::get('Login', [LevelUserController::class, 'login'])->name('login');
// Route::get('Register', [LevelUserController::class, 'register'])->name('register');
// Route::post('Insert_register', [LevelUserController::class, 'insert_register'])->name('insert_register');
// Route::post('Insert_login', [LevelUserController::class, 'Authlogin'])->name('insert_login');
// Route::get('Logout', [LevelUserController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['check.roleuser']], function () {
    //User
    Route::get('DashBoard_User', [UserController::class, 'dashboardUser'])->name('dashboard_user');
    Route::post('Booking_Rooms', [UserController::class, 'booking_rooms'])->name('booking_rooms');
    Route::get('Update_status_user/{id}/{value}', [UserController::class, 'update_status_user'])->name('update_status_user');
    Route::get('View_Status/{id}', [UserController::class, 'statusRoom'])->name('statusRoom');
    Route::get('History/{id}', [UserController::class, 'history'])->name('history');
    Route::get('ErrorUser/{id}', [UserController::class, 'error_user'])->name('error_user');
    Route::get('Update_status_user_User/{id}/{value}', [UserController::class, 'update_status_user_user'])->name('update_status_user_user');
});

Route::get('/', [AuthController::class, 'signin'])->name('user.signin');
Route::post('user/signin', [AuthController::class, 'signinCallback'])->name('user.signinCallback');
Route::get('user/signout', [AuthController::class, 'signout'])->name('user.signout');
Route::get('user/signout', [AuthController::class, 'signoutCallback'])->name('user.signoutCallback');
