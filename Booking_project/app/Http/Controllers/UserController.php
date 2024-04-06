<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\listRoom;
use App\Models\typeRoom;
use App\Models\work_time;
use App\Models\book_details;
use App\Models\booking;
use App\Models\Leveluser;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    function dashboardUser()
    {
        $room = listRoom::with('typeRoom')->get();
        $book_details = book_details::with('booking')->get();

        // ดึงวันที่ปัจจุบัน
        $today = Carbon::today()->toDateString();

        // ดึงข้อมูล booking ที่มีวันที่สร้างเท่ากับวันปัจจุบัน
        $booking = booking::with('work_time')
            ->whereDate('created_at', $today)
            ->where('status_book', 'ยืนยันการจอง')
            ->get();

        // ดึง work_times ที่ไม่เหมือนกับค่าที่ได้จาก booking ในคอลัม workTime_id
        $work_times = work_time::with('listRoom')
            ->whereNotIn('id', $booking->pluck('workTime_id'))
            ->get();


        return view('User.dashboard', compact('room', 'work_times', 'book_details'));
    }

    function booking_rooms(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $bookValidation = Booking::where('workTime_id', $request->select_time)
            ->whereDate('created_at', $today)
            ->where('status_book', 'ยืนยันการจอง')
            ->first();

        foreach ($request->pass_number as $pass_user) {
            $userValidation = Leveluser::where('passWordNumber_user', $pass_user)->first();
            if ($userValidation) {
                $findBookdetails = Book_Details::where('user_id', $userValidation->id)
                    ->whereDate('created_at', $today)
                    ->get();
                foreach ($findBookdetails as $find) {
                    $findBooking = Booking::where('id', $find->booking_id)
                        ->where(function ($query) {
                            $query->where('status_book', 'ยืนยันการจอง')
                                ->orWhere('status_book', 'รอยืนยันการจอง');
                        })
                        ->exists();
                    if ($findBooking) {
                        return back()->with('error', 'มีชื่อผู้ใช้ทำการลงทะเบียนการจองในวันนี้ไปแล้ว');
                    }
                }
            } else {
                return back()->with('error', 'ไม่พบข้อมูลผู้ใช้');
            }
        }


        if (!$bookValidation) {

            $booking = new booking();
            $booking->workTime_id = $request->select_time;
            $booking->status_book = 'รอการยืนยันการจอง';
            $booking->save();

            $id_book = $booking->id;

            foreach ($request->pass_number as $pass_user) {
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
        } else {
            return back()->with('error', 'เวลานี้มีการเข้าจองแล้ว');
        }
    }

    function update_status_user($id, $value)
    {
        booking::find($id)->update([
            'status_book' => $value
        ]);
        if ($value == 'ยกเลิกการจอง') {
            return back()->with('success', 'ทำการยกเลิกการจองห้องเรียบร้อย');
        } else {
            return back()->with('error', 'การอัปเดทล้มเหลว');
        }
    }

    function statusRoom($id)
    {
        $currentDate = Carbon::now()->toDateString();
        $book_details = book_details::with('booking')->where('user_id', $id)->whereDate('created_at', $currentDate)->get();
        return view('User.status_user', compact('book_details'));
    }

    function history($id)
    {
        $book_details = book_details::with('booking')->where('user_id', $id)->get();
        return view('User.history_user', compact('book_details'));
    }
}
