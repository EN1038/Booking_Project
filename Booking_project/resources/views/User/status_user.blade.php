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
<link rel="stylesheet" href="{{asset('css/User/status_user.css')}}">
<div class="row">
    <h1 class="text-center fw-bold text-greenlight mb-3">เช็คสถานะการจอง</h1>
  @foreach ($book_details as $items)
  <div class="col-md-6 col-xl-6 mt-1">
    <div class="card bg">
      <div class="card-body">
        <h5 class="card-title">ชื่อห้อง <span>{{$items->booking->work_time->listRoom->name_room}}</span></h5>
        <p class="card-text">วันที่ถูกจอง <span>{{ \Carbon\Carbon::parse($items->booking->created_at)->translatedFormat('d M') }} {{ \Carbon\Carbon::parse($items->booking->created_at)->year + 543 }}</span></p>
        <p class="card-text ">เวลาในการจอง <span>{{ \Carbon\Carbon::parse($items->booking->work_time->name_start_workTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($items->booking->work_time->name_end_workTime)->format('H:i') }}</span></p>               
                <p class="card-text">สถานะรายการ </p>
                <p class="card-text text-center border border-success p-1 rounded-4 fw-bold fs-5">{{$items->booking->status_book}}</p>
                <button class="btn btn-danger mb-2 w-100 rounded-3" id="select_status{{$items->id}}" data-work_time_id="{{$items->booking->work_time->id}}" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}" onclick="changStatus()" {{($items->booking->status_book === 'ยืนยันการจอง' || $items->booking->status_book === 'ปฎิเสธการจอง' || $items->booking->status_book === 'ยกเลิกการจอง') ? 'disabled' : '' }} value="ยกเลิกการจอง"> ยกเลิกการจอง</button>
        <p class="card-text text-danger fw-bold fs-5" id="countDown" data-timecancel="{{$items->booking->work_time->listRoom->typeRoom->time_cancel}}" data-id="{{$items->id}}" data-timestart="{{$items->booking->work_time->name_start_workTime}}"></p>
      </div>
    </div>
  </div>
  @endforeach
  
</div>
  <script src="{{asset('js/User/statusRoom.js')}}"></script>
@endsection