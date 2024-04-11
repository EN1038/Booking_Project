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
use App\Models\Leveluser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    function dashBoard_admin()
    {
        $room = listRoom::with('typeRoom')->get();
        return view('Admin.dashboard', compact('room'));
    }

    function view_listroom($id)
    {

        $room = listRoom::with('typeRoom')->where('id', $id)->first();
        $workTimes = work_time::with('listRoom')->where('id_room', $id)->paginate(9);
        return view('Admin.list_workTime_room', compact('workTimes', 'room'));
    }

    function create_room()
    {
        $room = listRoom::with('typeRoom')->paginate(9);
        $type_rooms = typeRoom::all();
        $work_times = work_time::with('listRoom')->get();
        return view('Admin.create_room', compact('type_rooms', 'room', 'work_times'));
    }

    function api_room()
    {
        $room = listRoom::all();
        return response()->json($room);
    }

    function insert_room(Request $request)
    {
        dd($request);
        if ($request->has('nameRoom') && $request->has('type_room') && $request->has('time_start_working') && $request->has('status_room')) {

            $existing_room = listRoom::where('name_room', $request->nameRoom)->first();

            if ($existing_room) {
                return back()->with('error', 'มีชื่อห้องซ้ำ');
            }

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
                $time_work->status_wt = 'จองห้อง';
                $time_work->id_room = $id_room; // ใช้ id ของห้องที่เพิ่งสร้าง
                $time_work->save();
            }

            return back()->with('success', 'สร้างห้องสำเร็จ');
        } else {
            return back()->with('error', -'สร้างห้องไม่สำเร็จ');
        }
    }

    function update_room(Request $request, $id)
    {
        // ค้นหาห้องที่ต้องการอัปเดต
        $room = ListRoom::find($id);

        $existing_room = listRoom::where('name_room', $request->updateNameRoom)->first();

        if ($existing_room) {
            return back()->with('error', 'มีชื่อห้องซ้ำ');
        }

        if (!$room) {
            return back()->with('error', 'ไม่พบห้องที่ต้องการอัปเดต');
        }

        // อัปเดตข้อมูลห้อง
        $room->name_room = $request->updateNameRoom;
        $room->save();

        return back()->with('success', 'อัปเดตห้องเรียบร้อยแล้ว');
    }

    function delete_room($id)
    {

        listRoom::find($id)->delete();
        work_time::where('id_room', $id)->delete();
        return back()->with('success', 'ทำการลบสำเร็จ');
    }

    function delete_listroom($id)
    {

        work_time::find($id)->delete();
        return back()->with('success', 'ทำการลบสำเร็จ');
    }

    function change_status($id)
    {

        $room = listRoom::where('id', $id)->first();
        $status = $room->status_room;
        if ($status === 'On') {
            listRoom::find($id)->update([
                'status_room' => 'Off'
            ]);
            return back()->with('success', 'โหมดห้องเปลี่ยนเป็น ปิด');
        } else {
            listRoom::find($id)->update([
                'status_room' => 'On'
            ]);
            return back()->with('success', 'โหมดห้องเปลี่ยนเป็น เปิด');
        }
    }

    function create_typeroom()
    {
        $type_rooms = typeRoom::paginate(9);
        return view('Admin.create_typeroom', compact('type_rooms'));
    }


    function delete_type_rooms($id)
    {
        typeRoom::find($id)->delete();
        return back()->with('success', 'ทำการลบสำเร็จ');
    }


    function insert_typeroom(Request $request)
    {
        if ($request->has('nameTypeRooms') && $request->has('numberUser') && $request->has('trueTime')) {

            $existing_typeRoom = typeRoom::where('name_type', $request->nameTypeRooms)->first();

            if ($existing_typeRoom) {
                return back()->with('error', 'มีชื่อห้องซ้ำ');
            }

            $data = new typeRoom();
            $data->name_type = $request->nameTypeRooms;
            $data->time_duration = $request->trueTime;
            $data->time_cancel = $request->trueTimeCancel;
            $data->number_user = $request->numberUser;
            $data->save();

            return back()->with('success', 'สร้างประเภทห้องสำเร็จ');
        } else {
            return back()->with('error', 'สร้างประเภทห้องไม่สำเร็จ');
        }
    }

    function edit_type_rooms(Request $request, $id)
    {

        if ($request->has('editNameTypeRooms') && $request->has('editNumberUser') && $request->has('editTrueTime') && $request->has('trueEditTimeCancel')) {
            $existing_typeRoom = typeRoom::where('name_type', $request->editNameTypeRooms)->first();

            if ($existing_typeRoom) {
                return back()->with('error', 'มีชื่อห้องซ้ำ');
            }
            typeRoom::find($id)->update([
                'name_type' => $request->editNameTypeRooms,
                'time_duration' => $request->editTrueTime,
                'time_cancel' => $request->trueEditTimeCancel,
                'number_user' => $request->editNumberUser,
            ]);

            return back()->with('success', 'แก้ไขประเภทห้องสำเร็จ');
        } else {
            return back()->with('error', 'แก้ไขประเภทห้องไม่สำเร็จ');
        }
    }

    function status_room()
    {
        $today = Carbon::now()->setTimezone('Asia/Bangkok');
        $book_details = book_details::with('booking')
            ->whereDate('created_at', $today)
            ->latest()
            ->paginate(15);

        $book = book_details::with('Leveluser')
            ->whereDate('created_at', $today)
            ->groupBy('booking_id')
            ->select('booking_id', DB::raw('GROUP_CONCAT(user_id) as user_ids'))
            ->get();

        foreach ($book as $item) {
            $user_ids = explode(',', $item->user_ids);
            $users = Leveluser::whereIn('id', $user_ids)->pluck('name_user')->toArray();
            $item->user_names = implode(', ', $users);
        }
        return view('Admin.status_room', compact('book_details', 'book'));
    }

    function update_status_admin($id, $value)
    {

        booking::find($id)->update([
            'status_book' => $value
        ]);
        if ($value == 'ยืนยันการจอง') {
            return back()->with('success', 'ทำการยืนยันการจองห้องเรียบร้อย');
        } else if ($value == 'ปฎิเสธการจอง') {
            return back()->with('success', 'ทำการปฎิเสธการจองห้องเรียบร้อย');
        } else {
            return back()->with('error', 'การอัปเดทล้มเหลว');
        }
    }

    function history_room()
    {
        $today = Carbon::now()->setTimezone('Asia/Bangkok');

        $book_details = book_details::with('booking')
            ->latest()
            ->paginate(15);

        $book = book_details::with('Leveluser')
            ->groupBy('booking_id')
            ->select('booking_id', DB::raw('GROUP_CONCAT(user_id) as user_ids'))
            ->get();

        foreach ($book as $item) {
            $user_ids = explode(',', $item->user_ids);
            $users = Leveluser::whereIn('id', $user_ids)->pluck('name_user')->toArray();
            $item->user_names = implode(', ', $users);
        }
        return view('Admin.history_room', compact('book_details', 'book'));
    }

    function update_wt($id)
    {
        $wt = work_time::where('id', $id)->first();
        $status = $wt->status_wt;
        if ($status === 'จองห้อง') {
            work_time::find($id)->update([
                'status_wt' => 'ว็อกอิน'
            ]);
            return back()->with('success', 'โหมดเวลาเปลี่ยนเป็น ว็อกอิน');
        } else {
            work_time::find($id)->update([
                'status_wt' => 'จองห้อง'
            ]);
            return back()->with('success', 'โหมดเวลาเปลี่ยนเป็น จองห้อง');
        }
    }

    function booking_admin()
    {
        $room = listRoom::with('typeRoom')->get();
        $book_details = book_details::with('booking')->get();

        // ดึงวันที่ปัจจุบัน
        $today = Carbon::now()->toDateString();

        // ดึงข้อมูล booking ที่มีวันที่สร้างเท่ากับวันปัจจุบัน
        $booking = booking::with('work_time')
            ->whereDate('created_at', $today)
            ->where('status_book', 'ยืนยันการจอง')
            ->get();

        // ดึง work_times ที่ไม่เหมือนกับค่าที่ได้จาก booking ในคอลัม workTime_id
        $work_times = work_time::with('listRoom')
            ->whereNotIn('id', $booking->pluck('workTime_id'))
            ->get();

        return view('Admin.booking_admin', compact('room', 'work_times', 'book_details'));
    }

    function insert_booking_admin(Request $request)
    {
        $today = Carbon::now()->setTimezone('Asia/Bangkok');
        $bookValidation = Booking::where('workTime_id', $request->select_time)
            ->whereDate('created_at', $today)
            ->whereIn('status_book', ['ยืนยันการจอง', 'รอยืนยันการจอง'])
            ->first();


        foreach ($request->pass_number as $pass_user) {
            $userValidation = Leveluser::where('passWordNumber_user', $pass_user)->first();
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
}
