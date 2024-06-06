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
<link rel="stylesheet" href="{{asset('css/Admin/history.css')}}">
<div class="row">
  <h1 class="text-center fw-bold text-greenlight mb-3">ประวัติการจอง</h1>
<div class="d-flex justify-content-end">
  <input type="date" id="searchInput" onchange="searchTable(4)" class="form-control input-custume m-2 w-25" placeholder="ค้นหา...">
  <input type="text" id="searchInput2" onkeyup="searchTable(2)" class="form-control input-custume m-2 w-25" placeholder="ค้นหา...">
</div>

<table id="dataTable">
  <thead>
    <tr>
      <th scope="col">รายชื่อคนทำการจอง</th>
      <th scope="col">ชื่อห้อง</th>
      <th scope="col">ประเภทห้อง</th>
      <th scope="col">ระยะเวลาที่จอง</th>
      <th scope="col">ถูกจองวันที่</th>
      <th scope="col">การอนุมัติ</th> 
    </tr>
  </thead>
    <tbody>
        @php
          $previous = null;
        @endphp
        @foreach ($book_details as $items)
          @if ($items->booking->status_book == 'ยืนยันการจอง' || $items->booking->status_book == 'ปฎิเสธการจอง' || $items->booking->status_book == 'ยกเลิกการจอง')
              @if($items->booking->workTime_id != $previous)
              @php
                  $previous = $items->booking->workTime_id;
              @endphp
              <tbody> 
                <tr>
                    <td data-label="รายชื่อคนทำการจอง"><button type="button" class="btn btn-success text-light" data-bs-toggle="modal" data-bs-target="#listMember{{$items->booking_id}}">
                      <i class="fa-solid fa-users"></i> ดูข้อมูลสมาชิก
                    </button></td>
                    <td data-label="ชื่อห้อง">{{$items->booking->work_time->listRoom->name_room}}</td>
                    <td data-label="ประเภทห้อง">{{$items->booking->work_time->listRoom->typeRoom->name_type}}</td>
                    <td data-label="ระยะเวลาที่จอง">{{ \Carbon\Carbon::parse($items->booking->work_time->name_start_workTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($items->booking->work_time->name_end_workTime)->format('H:i') }}</td>
                    {{-- <td data-label="ถูกจองวันที่">{{ $items->booking->created_at->toDateString() }}</td> --}}
                    <td data-label="ถูกจองวันที่">{{ \Carbon\Carbon::parse($items->updated_at)->translatedFormat('d M') }} {{ \Carbon\Carbon::parse($items->updated_at)->year + 543 }} {{ \Carbon\Carbon::parse($items->updated_at)->format('H:i') }}</td>
                    <td data-label="การอนุมัติ" class="form-css fw-bold">{{$items->booking->status_book}}</td>
                </tr>
              </tbody>
              @endif
          @endif 
        @endforeach
    </tbody>
  </table>
  {{ $book_details->withQueryString()->links('pagination::bootstrap-4') }}
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
        <ul>
          @foreach ($book as $user)
              @if ($user->booking_id == $items->booking_id)
                  @foreach (explode(',', $user->user_names) as $name)
                      <li>{{ $name }}</li>
                  @endforeach
              @endif
          @endforeach
          </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> ปิด</button>
      </div>
    </div>
  </div>
</div>
@endforeach
<script src="{{asset('js/Admin/history_room.js')}}"></script>
@endsection