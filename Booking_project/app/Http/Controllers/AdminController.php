<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\typeRoom;

class AdminController extends Controller
{
    //
    function dashBoard_admin(){
        return view('Admin.dashboard');
    }

    function create_room(){
        return view('Admin.create_room');
    }

    function create_typeroom(){
        $type_rooms=DB::table('type_rooms')->get();
        return view('Admin.create_typeroom',compact('type_rooms'));
    }
    
    function delete_type_rooms($id){
        DB::table('type_rooms')->where('id',$id)->delete();
        return back();
    }

    function insert_typeroom(Request $request){
        if($request->has('nameTypeRooms') && $request->has('selectTimeDuration')){
            $typeRoom = new TypeRoom();
            $typeRoom->name_type = $request->nameTypeRooms;
            $typeRoom->time_duration = $request->selectTimeDuration;
            
            // บันทึกข้อมูลลงในฐานข้อมูล
            $typeRoom->save();
            
            return back()->with('success', true);
        }else{
            return back()->with('error', true);
        }
    } 
}
