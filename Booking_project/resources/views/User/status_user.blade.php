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
    <div class="card shadow bg">
      <div class="card-body">
        <h5 class="card-title">ชื่อห้อง <span>{{$items->booking->work_time->listRoom->name_room}}</span></h5>
        <p class="card-text">วันที่ถูกจอง <span>{{ \Carbon\Carbon::parse($items->booking->created_at)->translatedFormat('d M') }} {{ \Carbon\Carbon::parse($items->booking->created_at)->year + 543 }}</span></p>
        <p class="card-text ">เวลาในการจอง <span>{{ \Carbon\Carbon::parse($items->booking->work_time->name_start_workTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($items->booking->work_time->name_end_workTime)->format('H:i') }}</span></p>               
                <p class="card-text">สถานะห้อง <span>
                <select class="form-select rounded-5 w-100 text-center border-success" id="select_status{{$items->id}}" onchange="changStatus()" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}"  {{$items->booking->status_book === 'ยกเลิกการจอง' || $items->booking->status_book === 'ยืนยันการจอง' || $items->booking->status_book === 'ปฎิเสธการจอง' ? 'disabled' : '' }} disabled>
                    <option value="{{$items->booking->status_book}}" class="text-warning" selected hidden>{{$items->booking->status_book}}</option>
                    <option value="ยกเลิกการจอง" class="text-danger">ยกเลิกการจอง</option>
                </select></span></p>               
        <p class="card-text text-danger fw-bold fs-5" id="countDown" data-timecancel="{{$items->booking->work_time->listRoom->typeRoom->time_cancel}}" data-id="{{$items->id}}" data-timestart="{{$items->booking->work_time->name_start_workTime}}"></p>
      </div>
    </div>
  </div>
  @endforeach
  
</div>
  <script src="{{asset('js/User/statusRoom.js')}}"></script>
@endsection