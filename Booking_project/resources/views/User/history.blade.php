@extends('Layout.layout_user.layout')
@section('content')
@if(session('success'))
    <script>
        Swal.fire({
            title: 'สำเร็จ!',
            text: '{{ session('success') }}',
            icon: 'success'
        });
    </script>
@elseif (session('error'))
    <script>
        Swal.fire({
        title: 'ผิดพลาด!',
        text: '{{ session('error') }}',
        icon: 'error'
    });
    </script>
@endif
<table class="table">
    <thead>
      <tr>
        <th scope="col" class="col-2">ชื่อห้อง</th>
        <th scope="col" class="col-2">เวลาในการจอง</th>
        <th scope="col" class="col-3">สถานะห้อง</th>
        <th scope="col" class="col-5">เวลาที่เหลือ</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($book_details as $items)
        <tr>
            <td>{{$items->booking->work_time->listRoom->name_room}}</td>
            <td>{{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</td>
            <td>
                <select class="form-select" id="select_status{{$items->id}}" onchange="changStatus()" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}"  {{$items->booking->status_book === 'ยกเลิกการจอง' || $items->booking->status_book === 'ยืนยันการจอง' || $items->booking->status_book === 'ปฎิเสธการจอง' ? 'disabled' : '' }} disabled>
                    <option value="{{$items->booking->status_book}}" class="text-warning" selected hidden>{{$items->booking->status_book}}</option>
                    <option value="ยกเลิกการจอง" class="text-danger">ยกเลิกการจอง</option>
                </select>
            </td>
            <td id="countDown" data-timecancel="{{$items->booking->work_time->listRoom->typeRoom->time_cancel}}" data-id="{{$items->id}}" data-timestart="{{$items->booking->work_time->name_start_workTime}}">
            
            </td>
          </tr>
          
    @endforeach
    </tbody>
  </table>
  <script src="{{asset('js/User/statusRoom.js')}}"></script>
@endsection