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
<div class="col-12 px-4">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ชื่อคนทำการจอง</th>
            <th scope="col">ชื่อห้อง</th>
            <th scope="col">ประเภทห้อง</th>
            <th scope="col">ระยะเวลาการใช้งาน</th>
            <th scope="col">การอณุมัติ</th>
            
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
                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#listMember{{$items->booking_id}}">
                          ดูข้อมูลสมาชิก
                        </button></td>
                        <td>{{$items->booking->work_time->listRoom->name_room}}</td>
                        <td>{{$items->booking->work_time->listRoom->typeRoom->name_type}}</td>
                        <td>{{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</td>
                        <td>
                            <select class="form-select" onchange="changStatus()" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}"  {{($items->booking->status_book === 'ยืนยันการจอง' || $items->booking->status_book === 'ปฎิเสธการจอง') ? 'disabled' : '' }}>
                                <option value="{{$items->booking->status_book}}" class="text-warning" selected hidden>{{$items->booking->status_book}}</option>
                                <option value="ยืนยันการจอง" class="text-success">ยืนยันการจอง</option>
                                <option value="ปฎิเสธการจอง" class="text-danger">ปฎิเสธการจอง</option>
                              </select>
                        </td>
                    </tr>
                </tbody>
            @endif
        @endforeach
      </table> 


      
</div>
@foreach ($book_details as $items)
<div class="modal fade" id="listMember{{$items->booking_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">รายชื่อคนจองห้อง{{$items->booking->work_time->listRoom->name_room}}ในเวลา {{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach ($book_details as $user)
          <p>{{$user->Leveluser->name_user}}</p>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endforeach
<script src="{{asset('js/Admin/statusRoom.js')}}"></script>
@endsection