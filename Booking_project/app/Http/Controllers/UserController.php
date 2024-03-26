<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\listRoom;
use App\Models\typeRoom;
use App\Models\work_time;

class UserController extends Controller
{
    //
    function dashboardUser(){
        $room = listRoom::with('typeRoom')->get();
        $work_times = work_time::with('listRoom')->get();
        return view('User.dashboard',compact('room','work_times'));
    }
}
