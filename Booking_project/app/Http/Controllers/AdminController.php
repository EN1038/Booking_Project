<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\listRoom;
use App\Models\typeRoom;


class AdminController extends Controller
{
    //
    function dashBoard_admin(){
        return view('Admin.dashboard');
    }

    function create_room(){
        $room = listRoom::with('typeRoom')->get();
        $type_rooms = typeRoom::all();
        return view('Admin.create_room',compact('type_rooms','room'));
    }

    function api_room(){
        $room = listRoom::all();
        return response()->json($room);
    }

    function insert_room(Request $request){
        if($request->has('nameRoom') && $request->has('type_room')&& $request->has('time_working')&& $request->has('status_room')){
            
            foreach ($request->time_working as $time) {
                $room = new listRoom();
                $room->name_room = $request->nameRoom;
                $room->time_working = $time;
                $room->status_room = $request->status_room;
                $room->id_type_room = $request->type_room;
                $room->save(); // บันทึกแถวใหม่ลงในฐานข้อมูล
            };
            return back()->with('success', true);
        }else{
            return back()->with('error', true);
        }
    }

    function delete_room($id){
        listRoom::find($id)->delete();
        return back();
    }

    function change_status($id){
        $room = listRoom::where('id', $id)->first();
        $status = $room->status_room;
        if($status === 'On'){
            listRoom::find($id)->update([
                'status_room' => 'Off'
            ]);
        }else{
            listRoom::find($id)->update([
                'status_room' => 'On'
            ]);
        }
        return back();
    }

    function create_typeroom(){
        $type_rooms=typeRoom::paginate(10);
        return view('Admin.create_typeroom',compact('type_rooms'));
    }

    
    function delete_type_rooms($id){
        typeRoom::find($id)->delete();
        return back();
    }


    function insert_typeroom(Request $request){
        if($request->has('nameTypeRooms') && $request->has('numberUser')&& $request->has('trueTime')){
            $data = new typeRoom();
            $data->name_type = $request->nameTypeRooms;
            $data->time_duration = $request->trueTime;
            $data->number_user = $request->numberUser;
            $data->save();
                   
            return back()->with('success', true);
        }else{
            return back()->with('error', true);
        }
    }
    
    function edit_type_rooms(Request $request,$id){
        if($request->has('editNameTypeRooms') && $request->has('editNumberUser')&& $request->has('editTrueTime')){

            typeRoom::find($id)->update([
                'name_type' => $request->editNameTypeRooms,
                'time_duration' => $request->editTrueTime,
                'number_user' => $request->editNumberUser,
            ]);
          
            return back()->with('success', true);
        }else{
            return back()->with('error', true);
        }
    }
}
