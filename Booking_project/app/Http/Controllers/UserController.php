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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    //
    function dashboardUser()
    {
        $room = listRoom::with('typeRoom')->get();
        $typeRoom = typeRoom::all();
        $book_details = book_details::with('booking')->get();

        // ดึงวันที่ปัจจุบัน
        $today = Carbon::now()->setTimezone('Asia/Bangkok');

        $work_times = work_time::get();

        foreach ($work_times as $time) {
            $booking = booking::where('workTime_id', $time->id)
                            ->whereDate('created_at', $today)
                            ->first();
        
            $start_time = Carbon::createFromFormat('H:i:s', $time->name_start_workTime);
            $end_time = Carbon::createFromFormat('H:i:s', $time->name_end_workTime);
        
            if ($booking) {
                // ถ้าห้องรับการยืนยัน
                if ($booking->status_book === 'ยืนยันการจอง') {
                    $time->work_status = 'booked';
                    // ถ้าห้องยังไม่ได้่รับการยืนยัน
                } elseif ($booking->status_book === 'รอยืนยันการจอง') {
                    $time->work_status = 'wait_book';
                }
            } elseif (Carbon::now()->greaterThan($end_time)) {
                // ถ้าเวลาปัจจุบันเกินเวลาสิ้นสุด
                $time->work_status = 'close_book';
            } elseif (Carbon::now()->greaterThan($start_time)) {
                // ถ้าเวลาปัจจุบันเกินเวลาเริ่มต้น
                $time->work_status = 'walk_in';
            } else {
                // สถานะเริ่มต้น ถ้าเวลาปัจจุบันยังไม่เกินเวลาเริ่มต้น
                $time->work_status = 'open';
            }
        }
    // dd($work_times);

        if (Auth::user()->status_user == 'จองไม่ได้') {
            return redirect('ErrorUser/' . Auth::user()->id);
        } else if (Auth::user()->status_user == null) {
            return redirect('/');
        }


        return view('User.dashboard', compact('room', 'work_times', 'book_details', 'typeRoom'));
    }

    function booking_rooms(Request $request)
    {
        $today = Carbon::now()->setTimezone('Asia/Bangkok');
        $bookValidation = Booking::where('workTime_id', $request->select_time)
            ->whereDate('created_at', $today)
            ->whereIn('status_book', ['ยืนยันการจอง', 'รอยืนยันการจอง'])
            ->first();


        foreach ($request->pass_number as $pass_user) {
            $userValidation = Leveluser::where('passWordNumber_user', $pass_user)->first();
            if ($userValidation->status_user == 'จองไม่ได้') {
                return back()->with('error', 'มีชื่อผู้ใช้ที่ไม่มีสิทในการเข้าจอง');
            }
            if ($userValidation) {
                $findBookdetails = Book_Details::where('user_id', $userValidation->id)
                    ->whereDate('book_details.created_at', $today)
                    ->join('bookings', 'book_details.booking_id', '=', 'bookings.id')
                    ->whereIn('bookings.status_book', ['ยืนยันการจอง', 'รอยืนยันการจอง'])
                    ->exists();
                if ($findBookdetails) {
                    return back()->with('error', 'มีชื่อผู้ใช้ทำการลงทะเบียนการจองไปแล้ว');
                }
            } else {
                return back()->with('error', 'ไม่พบข้อมูลผู้ใช้');
            }
        }


        if (!$bookValidation) {

            $booking = new booking();
            $booking->workTime_id = $request->select_time;
            $booking->status_book = 'รอยืนยันการจอง';
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
        App::setLocale('th');
        Carbon::setLocale('th');
        if ($id != auth::user()->id) {
            return redirect('/');
        } else {
            $currentDate = Carbon::now()->setTimezone('Asia/Bangkok');
            $book_details = book_details::with('booking')->where('user_id', $id)->whereDate('created_at', $currentDate)->get();
            return view('User.status_user', compact('book_details'));
        }
    }

    function history($id)
    {
        App::setLocale('th');
        Carbon::setLocale('th');
        if ($id != auth::user()->id) {
            return redirect('/');
        } else {
            $book_details = book_details::with('booking')->where('user_id', $id)->paginate(20);
            return view('User.history_user', compact('book_details'));
        }
    }

    function error_user($id)
    {
        if ($id != auth::user()->id) {
            return redirect('/');
        } else {
            $error_user = Leveluser::where('id', $id)->first();
            return view('User.error_user', compact('error_user'));
        }
    }

    function update_status_user_user($id, $value)
    {
        $user = Leveluser::find($id);
        $user->update([
            'goodness_user' => 0,
            'status_user' => $value,
        ]);
        return redirect('DashBoard_User');
    }
}
