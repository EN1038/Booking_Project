@extends('Layout.layout_admin.layout')
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
<link rel="stylesheet" href="{{asset('css/Admin/status_room.css')}}">
<div class="row">
  <h1 class="text-center fw-bold text-greenlight mb-3">รายการรอการอนุมัติ</h1>
    <table>
        <thead>
          <tr>
            <th scope="col" class="col-1">ลำดับที่</th>
            <th scope="col">รายชื่อคนทำการจอง</th>
            <th scope="col">ชื่อห้อง</th>
            <th scope="col">ประเภทห้อง</th>
            <th scope="col">ระยะเวลาที่จอง</th>
            <th scope="col">เวลาก่อนจะปฎิเสธ</th>
            <th scope="col">สถานะรายการ</th>
            <th scope="col">การอนุมัติ</th>
            
          </tr>
        </thead>
        @php
          $previous = null;
        @endphp
        
        @foreach ($book_details as $items)
            @if($items->booking->workTime_id != $previous)
                @php
                    $previous = $items->booking->workTime_id;
                @endphp
                <tbody> 
                    <tr>
                        <td data-label="ลำดับที่">{{ $loop->iteration }}</td>
                        <td data-label="รายชื่อคนทำการจอง"><button type="button" class="btn btn-success text-light" data-bs-toggle="modal" data-bs-target="#listMember{{$items->booking_id}}">
                          <i class="fa-solid fa-users"></i> ดูข้อมูลสมาชิก
                        </button></td>
                        <td data-label="ชื่อห้อง">{{$items->booking->work_time->listRoom->name_room}}</td>
                        <td data-label="ประเภทห้อง">{{$items->booking->work_time->listRoom->typeRoom->name_type}}</td>
                        <td data-label="ระยะเวลาที่จอง">{{ \Carbon\Carbon::parse($items->booking->work_time->name_start_workTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($items->booking->work_time->name_end_workTime)->format('H:i') }}</td>
                        <td data-label="เวลาก่อนจะปฎิเสธ" class="card-text text-danger fw-bold fs-6" id="countDown" data-status_wt='{{$items->booking->work_time->status_wt}}' data-timelate="{{$items->booking->work_time->listRoom->typeRoom->time_late}}" data-id="{{$items->id}}" data-timestart="{{$items->booking->work_time->name_start_workTime}}"></td>
                        <td data-label="สถานะรายการ">
                          {{$items->booking->status_book}}
                        </td>
                        <td data-label="การอนุมัติ">
                            {{-- <select class="form-select text-center border border-success rounded-4" id="select_status{{$items->id}}" onchange="changStatus()" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}"  {{($items->booking->status_book === 'ยืนยันการจอง' || $items->booking->status_book === 'ปฎิเสธการจอง' || $items->booking->status_book === 'ยกเลิกการจอง') ? 'disabled' : '' }}>
                                <option value="{{$items->booking->status_book}}" class="text-warning" selected hidden>{{$items->booking->status_book}}</option>
                                <option value="ยืนยันการจอง" class="text-success" >ยืนยันการจอง</option>
                            </select> --}}
                            <button class="btn btn-success rounded-3" id="select_status{{$items->id}}" data-work_time_id="{{$items->booking->work_time->id}}" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}" onclick="changStatus()" {{($items->booking->status_book === 'ยืนยันการจอง' || $items->booking->status_book === 'ปฎิเสธการจอง' || $items->booking->status_book === 'ยกเลิกการจอง') ? 'disabled' : '' }} value="ยืนยันการจอง"> ยืนยันการจอง </button>
                        </td>
                    </tr>
                </tbody>
            @endif
        @endforeach
      </table> 
      {{$book_details->withQueryString()->links('pagination::bootstrap-4')}} 
</div>

{{-- MODAL USER --}}
@foreach ($book_details as $items)
<div class="modal fade" id="listMember{{$items->booking_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-success" id="exampleModalLabel">รายชื่อคนจองในเวลา {{ \Carbon\Carbon::parse($items->booking->work_time->name_start_workTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($items->booking->work_time->name_end_workTime)->format('H:i') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="fw-bold">ห้อง {{$items->booking->work_time->listRoom->name_room}}</p>
        @foreach ($book as $user)
            @if ($user->booking_id == $items->booking_id)
                <ul>
                    @foreach (explode(',', $user->passWordNumber_user) as $index => $passWordNumber)
                        <li>{{ $passWordNumber }} - {{ explode(',', $user->user_name)[$index] }} {{ explode(',', $user->last_name)[$index] }}</li>
                    @endforeach
                </ul>
            @endif
        @endforeach

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> ปิด</button>
      </div>
    </div>
  </div>
</div>
@endforeach
<script src="{{asset('js/Admin/statusRoom.js')}}"></script>
@endsection