<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\listRoom;

class UserController extends Controller
{
    //
    function dashboardUser(){
        $room = listRoom::all();
        return view('User.dashboard',compact('room'));
    }
}
