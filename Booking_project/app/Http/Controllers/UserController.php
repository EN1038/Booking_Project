<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\listRoom;
use App\Models\typeRoom;
use App\Models\work_time;
use App\Models\book_details;
use App\Models\booking;
use App\Models\Leveluser;

class UserController extends Controller
{
    //
    function dashboardUser(){
        $room = listRoom::with('typeRoom')->get();
        $work_times = work_time::with('listRoom')->get();
        return view('User.dashboard',compact('room','work_times'));
    }

    function booking_rooms(Request $request){ 
        if($request->pass_number && $request->select_time){

            $booking = new booking();
                $booking->workTime_id = $request->select_time;
                $booking->status_book = 'รอการยืนยันการจอง';
                $booking->save();

                $id_book = $booking->id;

            foreach($request->pass_number as $pass_user){
                $level_user = Leveluser::where('passWordNumber_user', $pass_user)->first();
                if ($level_user) {
                    $book_detail = new book_details();
                    $book_detail->user_id = $level_user->id;
                    $book_detail->booking_id = $id_book;
                    $book_detail->save();
                } else {
                    // หากไม่พบข้อมูลในตาราง user สามารถส่งค่าอื่น ๆ กลับได้ตามที่คุณต้องการ
                    return back()->with('error', 'ไม่มีชื่อผู้ใช้ในระบบ');
                }
                
            }
                return back()->with('success', 'ทำการจองห้องเรียบร้อย รอการยืนยัน');
        }else{
            return back()->with('error', 'กรอกข้อมูลไม่ครบ');
        }
    }

    function update_statuus($id){

    }
}
