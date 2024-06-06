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
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
class AdminController extends Controller
{
    //
    function dashBoard_admin()
    {
        $today = Carbon::now()->setTimezone('Asia/Bangkok');
        $count_status_booking_wait = booking::whereDate('created_at', $today)->where('status_book', '=', 'รอยืนยันการจอง')->pluck('id');
        $count_status_booking_wait_details = book_details::whereIn('booking_id', $count_status_booking_wait)->count();
        $count_status_booking_success = booking::whereDate('created_at', $today)->where('status_book', '=', 'ยืนยันการจอง')->pluck('id');
        $count_status_booking_success_details = book_details::whereIn('booking_id', $count_status_booking_success)->count();
        $count_status_booking_insuccess = booking::whereDate('created_at', $today)->where('status_book', '=', 'ปฎิเสธการจอง')->pluck('id');
        $count_status_booking_insuccess_details = book_details::whereIn('booking_id', $count_status_booking_insuccess)->count();
        $count_status_booking = booking::whereDate('created_at', $today)->pluck('id');
        $count_status_booking_details = book_details::whereIn('booking_id', $count_status_booking)->count();

        $booking_ids = Booking::where('status_book', 'ยืนยันการจอง')->pluck('id');
        $all_booking_details = [];
        $userCounts = [];

        foreach ($booking_ids as $booking_id) {
            $booking_details = book_details::where('booking_id', '=', $booking_id)
                ->orderBy('id') // เรียงลำดับ id ของ book_details
                ->get();

            foreach ($booking_details as $booking_detail) {
                $user_id = $booking_detail->user_id;

                // เพิ่ม user_id เข้าไปใน $all_booking_details
                $all_booking_details[] = $user_id;

                // เพิ่ม user_id เข้าไปใน $userCounts และนับจำนวน
                if (!isset($userCounts[$user_id])) {
                    $userCounts[$user_id] = [
                        'id' => $user_id,
                        'pass_Wordnumber' => $booking_detail->leveluser->passWordNumber_user,
                        'name_user' => $booking_detail->leveluser->name_user,
                        'count' => 1,
                    ];
                } else {
                    $userCounts[$user_id]['count']++;
                }
            }
        }

        // dd($userCounts);

        // แปลง array เป็น Collection
        $userCountsCollection = collect($userCounts);

        // เรียงข้อมูลใน Collection จากมากไปหาน้อย
        $userCountsCollection = $userCountsCollection->sortByDesc('count');
        $perPage = 3;
        $page = request()->get('page', 1); // หากไม่มีค่า page ให้ใช้หน้าแรกเป็นค่าเริ่มต้น
        $offset = ($page * $perPage) - $perPage;
        $paginator = new LengthAwarePaginator(
            $userCountsCollection->slice($offset, $perPage), // นำ Collection มา slice เพื่อให้เหลือเฉพาะข้อมูลของหน้าที่กำลังแสดง
            $userCountsCollection->count(), // จำนวนรายการทั้งหมด
            $perPage, // จำนวนรายการต่อหน้า
            $page, // หน้าปัจจุบัน
            ['path' => request()->url(), 'query' => request()->query()] // ตัวแปรสำหรับ query string
        );

        $rooms = listRoom::all();
        $idTypeRoom = listRoom::distinct()->pluck('id_type_room');
        $typeRoom = typeRoom::whereIn('id', $idTypeRoom)->pluck('name_type');

        // นับจำนวนห้องที่เปิดและปิดการใช้งาน
        $onCount = $rooms->where('status_room', 'On')->count();
        $offCount = $rooms->where('status_room', 'Off')->count();

        // กำหนดข้อความที่ต้องการแสดง
        $message = '';
        if ($onCount > 0 && $offCount > 0) {
            $message = 'ห้องมีโหมดที่สลับกัน';
        } elseif ($onCount > 0) {
            $message = 'ห้องทั้งหมดเปิดใช้งาน';
        } elseif ($offCount > 0) {
            $message = 'ห้องทั้งหมดปิดการใช้งาน';
        }



        return view('Admin.dashboard', ['userCountsCollection' => $userCountsCollection], compact('message', 'count_status_booking_wait_details', 'count_status_booking_success_details', 'count_status_booking_insuccess_details', 'count_status_booking_details', 'paginator', 'typeRoom'));
    }

    function count_status_booking_wait()
    {
        $today = Carbon::now()->setTimezone('Asia/Bangkok');
        $count_status_booking_wait = booking::whereDate('created_at', $today)->where('status_book', '=', 'รอยืนยันการจอง')->count();
        return response()->json($count_status_booking_wait);
    }

    function api_pie()
    {
        $roomBookings = Booking::where('status_book', 'ยืนยันการจอง')->get();
        $workTimeIds = $roomBookings->pluck('workTime_id')->toArray();

        $roomCounts = [];

        foreach ($workTimeIds as $workTimeId) {
            $rooms = Work_Time::where('id', $workTimeId)
                ->with('listRoom')
                ->first();

            if ($rooms) {
                $roomId = $rooms->listRoom->id;

                if (!isset($roomCounts[$roomId])) {
                    $roomCounts[$roomId] = [
                        'id' => $roomId,
                        'name_room' => $rooms->listRoom->name_room,
                        'count' => 1,
                    ];
                } else {
                    $roomCounts[$roomId]['count']++;
                }
            }
        }

        $roomCountsCollection = collect(array_values($roomCounts));
        return response()->json($roomCountsCollection);
    }

    function api_typeRoom()
    {
    }

    function getBookingData(Request $request)
    {
        $typeRoom = typeRoom::first();
        $selectType = $request->input('select') ?? $typeRoom->name_type;
        $typeRoomSe = typeRoom::where('name_type', $selectType)->pluck('id');
        $typeRoomNu = typeRoom::where('name_type', $selectType)->pluck('number_user')->first();
        $selectedDate = $request->input('date') ?? now()->toDateString();
        // ดึงข้อมูลจากฐานข้อมูล

        $roomBookings = Booking::where('status_book', 'ยืนยันการจอง')->whereDate('created_at', $selectedDate)->pluck('workTime_id');
        $id_room = work_time::whereIn('id', $roomBookings)->pluck('id_room')->toArray();


        $roomCounts = [];

        foreach ($id_room as $room_id) {
            $check = listRoom::where('id', $room_id)->whereIn('id_type_room', $typeRoomSe)->first();

            if ($check) {
                $roomId = $check->id;

                if (!isset($roomCounts[$roomId])) {
                    $roomCounts[$roomId] = [
                        'id' => $roomId,
                        'date' => $selectedDate,
                        'name_room' => $check->name_room,
                        'count' => 1,
                    ];
                } else {
                    $roomCounts[$roomId]['count']++;
                }
            }
        }

        foreach ($roomCounts as &$roomCount) {
            $roomCount['count'] *= $typeRoomNu;
        }



        $roomCountsCollection = collect(array_values($roomCounts));
        return response()->json($roomCountsCollection);
    }

    function getBookingDataPie(Request $request)
    {
        $typeRoom = typeRoom::first();
        $selectType = $request->input('select') ?? $typeRoom->name_type;
        $typeRoomSe = typeRoom::where('name_type', $selectType)->pluck('id');
        $typeRoomNu = typeRoom::where('name_type', $selectType)->pluck('number_user')->first();
        $selectedMonth = $request->input('month') ?? now()->format('Y-m'); // เปลี่ยนเป็นรับค่าเดือน
        [$year, $month] = explode('-', $selectedMonth);

        // ดึงข้อมูลจากฐานข้อมูล
        $roomBookings = Booking::where('status_book', 'ยืนยันการจอง')
            ->whereYear('created_at', $year) // เฉพาะปีปัจจุบัน
            ->whereMonth('created_at', $month) // เฉพาะเดือนที่เลือก
            ->pluck('workTime_id');
        $id_rooms = work_time::whereIn('id', $roomBookings)->pluck('id_room')->toArray();

        $roomCounts = [];

        foreach ($id_rooms as $room_id) {
            $check = listRoom::where('id', $room_id)->whereIn('id_type_room', $typeRoomSe)->first();

            if ($check) {
                $roomId = $check->id;

                if (!isset($roomCounts[$roomId])) {
                    $roomCounts[$roomId] = [
                        'id' => $roomId,
                        'month' => $selectedMonth, // เปลี่ยนเป็นค่าเดือน
                        'name_room' => $check->name_room,
                        'count' => 1,
                    ];
                } else {
                    $roomCounts[$roomId]['count']++;
                }
            }
        }

        foreach ($roomCounts as &$roomCount) {
            $roomCount['count'] *= $typeRoomNu;
        }
        $roomCountsCollection = collect(array_values($roomCounts));
        return response()->json($roomCountsCollection);
    }

    function getBookingDataTotal(Request $request)
    {
        $selectedMonth = $request->input('month') ?? now()->format('Y-m'); // เปลี่ยนเป็นรับค่าเดือน
        [$year, $month] = explode('-', $selectedMonth);

        $roomBookings = Booking::where('status_book', 'ยืนยันการจอง')
            ->whereYear('created_at', $year) // เฉพาะปีปัจจุบัน
            ->whereMonth('created_at', $month) // เฉพาะเดือนที่เลือก
            ->pluck('id');

        $book_detail = book_details::whereIn('booking_id', $roomBookings)->pluck('user_id')->count();


        return response()->json($book_detail);
    }

    function view_listroom($id)
    {

        $room = listRoom::with('typeRoom')->where('id', $id)->first();
        $workTimes = work_time::with('listRoom')->where('id_room', $id)->paginate(9);
        return view('Admin.list_workTime_room', compact('workTimes', 'room'));
    }

    function create_room()
    {
        App::setLocale('th');
        Carbon::setLocale('th');

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

        if ($request->has('nameRoom') && $request->has('type_room') && $request->has('time_start_working') && $request->has('status_room') && $request->hasFile('image_room')) {

            $existing_room = listRoom::where('name_room', $request->nameRoom)->first();

            if ($request->hasFile('image_room')) {
                $image = $request->file('image_room');

                // ตรวจสอบรูปแบบของไฟล์ที่ถูกส่งมา
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = $image->getClientOriginalExtension();
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    // ถ้ารูปแบบของไฟล์ไม่ถูกต้อง
                    return back()->with('error', 'รูปภาพผิดประเภท');
                }
            }

            if ($existing_room) {
                return back()->with('error', 'มีชื่อห้องซ้ำ');
            }

            $room = new listRoom();
            if ($request->hasFile('image_room')) {
                $image = $request->file('image_room');
                $image_name = $image->getClientOriginalName();
                $image->storeAs('public/img', $image_name); // บันทึกไฟล์ภาพใน storage
                $room->image_room = $image_name; // บันทึกชื่อไฟล์ภาพในฐานข้อมูล
            }
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
            return back()->with('error', 'สร้างห้องไม่สำเร็จ หรือ กรอกข้อมูลไม่ครบ');
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

        if ($request->hasFile('image_editroom')) {
            $image = $request->file('image_editroom');

            // ตรวจสอบรูปแบบของไฟล์ที่ถูกส่งมา
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = $image->getClientOriginalExtension();
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                // ถ้ารูปแบบของไฟล์ไม่ถูกต้อง
                return back()->with('error', 'รูปภาพผิดประเภท');
            }
        }
        // อัปเดตข้อมูลห้อง
        $room->name_room = $request->updateNameRoom;

        // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
        if ($request->hasFile('image_editroom')) {
            // ลบรูปภาพเก่าออกจาก storage
            Storage::delete('public/img/' . $room->image_room);

            // อัปโหลดรูปภาพใหม่
            $image = $request->file('image_editroom');
            $image_name = $image->getClientOriginalName();
            $image->storeAs('public/img', $image_name); // บันทึกไฟล์ภาพใน storage
            $room->image_room = $image_name; // บันทึกชื่อไฟล์ภาพใหม่ในฐานข้อมูล
        }

        $room->save();


        return back()->with('success', 'อัปเดตห้องเรียบร้อยแล้ว');
    }

    function delete_room($id)
    {
        // ค้นหาห้องที่ต้องการลบ
        $room = listRoom::find($id);

        if (!$room) {
            return back()->with('error', 'ไม่พบห้องที่ต้องการลบ');
        }

        // ลบไฟล์ภาพที่เกี่ยวข้อง
        if ($room->image_room) {
            Storage::delete('public/img/' . $room->image_room);
        }

        // ลบห้อง
        $room->delete();

        // ลบข้อมูลที่เกี่ยวข้อง
        work_time::where('id_room', $id)->delete();

        return back()->with('success', 'ทำการลบสำเร็จ');
    }


    function delete_listroom($id)
    {

        work_time::find($id)->delete();
        return back()->with('success', 'ทำการลบสำเร็จ');
    }

    function all_change_status()
    {
        // ดึงข้อมูลห้องทั้งหมด
        $rooms = ListRoom::get();

        // วนลูปผ่านทุกห้อง
        foreach ($rooms as $room) {
            // เปลี่ยนสถานะของห้อง
            $newStatus = $room->status_room === 'On' ? 'Off' : 'On';
            $room->update(['status_room' => $newStatus]);
        }

        // ส่งกลับไปยังหน้าเดิมพร้อมกับข้อความสำเร็จ
        return back()->with('success', 'โหมดห้องถูกเปลี่ยนแล้ว');
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
            $data->time_late = $request->trueTimeLate;
            $data->number_user = $request->numberUser;
            $data->save();

            return back()->with('success', 'สร้างประเภทห้องสำเร็จ');
        } else {
            return back()->with('error', 'สร้างประเภทห้องไม่สำเร็จ');
        }
    }

    function edit_type_rooms(Request $request, $id)
    {
        if ($request->has('editNameTypeRooms') && $request->has('editNumberUser') && $request->has('editTrueTime') && $request->has('trueEditTimeCancel') && $request->has('trueEditTimeLate')) {
            $existing_typeRoom = typeRoom::where('name_type', $request->editNameTypeRooms)->first();

            if ($existing_typeRoom) {
                return back()->with('error', 'มีชื่อห้องซ้ำ');
            }
            typeRoom::find($id)->update([
                'name_type' => $request->editNameTypeRooms,
                'time_duration' => $request->editTrueTime,
                'time_cancel' => $request->trueEditTimeCancel,
                'time_late' => $request->trueEditTimeLate,
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
        // dd($book_details);
        return view('Admin.status_room', compact('book_details', 'book'));
    }

    function update_status_admin($id, $value)
    {

        $booking = booking::find($id);
        $booking->update([
            'status_book' => $value
        ]);
        $work_time = work_time::with('listRoom')->where('id', $booking->workTime_id)->first();
        $typeRoom = typeRoom::where('id', $work_time->listRoom->id_type_room)->first();
        $start_time = Carbon::createFromFormat('H:i:s', $work_time->name_start_workTime);
        $late_time = Carbon::createFromFormat('H:i:s', $typeRoom->time_late);
        $combined_time = $start_time->addMinutes($late_time->minute)->addHours($late_time->hour);
        $book_details = book_details::with('Leveluser')->where('booking_id', $id)->pluck('user_id');

        if ($value == 'ยืนยันการจอง') {
            if ($booking->updated_at <= $combined_time) { //มาสาย

                foreach ($book_details as $item) {
                    $user = Leveluser::where('id', $item)->first();
                    if ($user->goodness_user < 3) {
                        $user->goodness_user += 1; // เพิ่มค่า goodness_user ขึ้นไปอีก 1
                        if ($user->goodness_user == 3) {
                            $user->status_user = 'จองไม่ได้';
                            $user->cool_down_user = Carbon::now()->addMonths(3);
                        }
                        $user->save();
                    }
                }
            }
            return back()->with('success', 'ทำการยืนยันการจองห้องเรียบร้อย');
        } else if ($value == 'ปฎิเสธการจอง') {
            foreach ($book_details as $item) {
                $user = Leveluser::where('id', $item)->first();
                if ($booking->updated_at > $combined_time) { //ไม่มา
                    if ($user->goodness_user < 3) {
                        $user->goodness_user += 1; // เพิ่มค่า goodness_user ขึ้นไปอีก 1
                        if ($user->goodness_user == 3) {
                            $user->status_user = 'จองไม่ได้';
                            $user->cool_down_user = Carbon::now()->addMonths(3);
                        }
                        $user->save();
                    }
                }
            }
            return back()->with('success', 'ทำการปฎิเสธการจองห้องเรียบร้อย');
        } else {
            return back()->with('error', 'การอัปเดทล้มเหลว');
        }
    }

    function history_room()
    {
        App::setLocale('th');
        Carbon::setLocale('th');

        $today = Carbon::now()->setTimezone('Asia/Bangkok');

        $book_details = book_details::with('booking')
            ->latest()
            ->paginate(30);

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
        $typeRoom = typeRoom::all();
        $room = listRoom::with('typeRoom')->get();
        $book_details = book_details::with('booking')->get();

        // ดึงวันที่ปัจจุบัน
        $today = Carbon::now()->setTimezone('Asia/Bangkok');

        // ดึงข้อมูล booking ที่มีวันที่สร้างเท่ากับวันปัจจุบัน
        $booking = booking::with('work_time')
            ->whereDate('created_at', $today)
            ->where('status_book', 'ยืนยันการจอง')
            ->get();

        // ดึง work_times ที่ไม่เหมือนกับค่าที่ได้จาก booking ในคอลัม workTime_id
        $work_times = work_time::with('booking')
            ->whereNotIn('id', $booking->pluck('workTime_id'))
            ->get();


        foreach ($work_times as $work_time) {
            // ดึงเวลาเริ่มงานจากคอลัม 'name_start_workTime'
            $start_time = Carbon::createFromFormat('H:i:s', $work_time->name_start_workTime);
            $end_time = Carbon::createFromFormat('H:i:s', $work_time->name_end_workTime);

            // เปรียบเทียบเวลาปัจจุบันกับเวลาเริ่มงาน
            if ($today  >= $start_time) {
                // เปลี่ยนค่าคอลัม 'status_wt' เป็น 'ว็อกอิน'
                $work_time->status_wt = 'ว็อกอิน';
                $work_time->save(); // บันทึกการเปลี่ยนแปลงลงในฐานข้อมูล
                if ($today  >= $end_time) {
                    $work_time->status_wt = 'หมดเวลาจอง';
                    $work_time->save();
                }
            }
        }

        return view('Admin.booking_admin', compact('room', 'work_times', 'book_details', 'typeRoom'));
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

    function api_userLevel()
    {
        $user = Leveluser::select('passWordNumber_user')->get();

        return response()->json($user);
    }

    function change_leveluser()
    {
        return view('Admin.change_leveluser');
    }

    function change_level_user(Request $request)
    {
        if ($request->has('passNumberuser') && $request->has('select_level')) {
            $user = Leveluser::where('passWordNumber_user', $request->passNumberuser)->first();
            $user->update([
                'level_user' => $request->select_level,
            ]);
            return back()->with('success', 'เปลี่ยนระดับสำเร็จ');
        } else {
            return back()->with('error', 'กรอกข้อมูลไม่ครบ');
        }
    }
}
