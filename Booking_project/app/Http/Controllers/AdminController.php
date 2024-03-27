<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\listRoom;
use App\Models\typeRoom;
use App\Models\work_time;
use App\Models\booking;
use App\Models\book_details;


class AdminController extends Controller
{
    //
    function dashBoard_admin(){
        $room = listRoom::with('typeRoom')->get();
        return view('Admin.dashboard',compact('room'));
    }

    function view_listroom($id){
        $workTimes = work_time::with('listRoom')->where('id_room', $id)->get();
        return view('Admin.list_workTime_room',compact('workTimes'));
    }

    function create_room(){
        $room = listRoom::with('typeRoom')->get();
        $type_rooms = typeRoom::all();
        $work_times = work_time::with('listRoom')->get();
        return view('Admin.create_room',compact('type_rooms','room','work_times'));
    }

    function api_room(){
        $room = listRoom::all();
        return response()->json($room);
    }

    function insert_room(Request $request){
        if($request->has('nameRoom') && $request->has('type_room')&& $request->has('time_start_working')&& $request->has('status_room')){
            
            $room = new listRoom();
            $room->name_room = $request->nameRoom;
            $room->status_room = $request->status_room;
            $room->id_type_room = $request->type_room;
            $room->save();

            $id_room = $room->id; // รับค่า id ของห้องที่เพิ่งสร้าง

            foreach ($request->time_start_working as $index => $start_time) {
                $end_time = $request->time_end_working[$index]; // เวลาสิ้นสุดทำงานสำหรับ index เดียวกัน

                $time_work = new work_time();
                $time_work->name_start_workTime = $start_time;
                $time_work->name_end_workTime = $end_time; // เวลาสิ้นสุดทำงาน
                $time_work->id_room = $id_room; // ใช้ id ของห้องที่เพิ่งสร้าง
                $time_work->save();
                }

            return back()->with('success', true);
        }else{
            return back()->with('error', true);
        }
    }

    function update_room(Request $request,$id){
        // ค้นหาห้องที่ต้องการอัปเดต
            $room = ListRoom::find($id);

            if (!$room) {
                return back()->with('error', 'ไม่พบห้องที่ต้องการอัปเดต');
            }

            // อัปเดตข้อมูลห้อง
            $room->name_room = $request->updateNameRoom;
            $room->save();

            return back()->with('success', 'อัปเดตห้องเรียบร้อยแล้ว');
    }

    function delete_room($id){
        listRoom::find($id)->delete();
        work_time::where('id_room', $id)->delete();
        return back();
    }

    function delete_listroom($id){
        work_time::find($id)->delete();
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

    function status_room(){
        $book_details = book_details::with('booking')->get();
        $book = book_details::with('Leveluser')->get();
        return view('Admin.status_room',compact('book_details','book'));
    }
}
