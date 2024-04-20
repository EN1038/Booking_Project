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
<link rel="stylesheet" href="{{asset('css/User/history.css')}}">
<div class="row">
    <h1 class="text-center fw-bold text-greenlight mb-3">ประวัติการจอง</h1>
  <div class="d-flex justify-content-end">
    <input type="date" id="searchInput" onchange="searchTable()" class="form-control input-custume m-2 w-25" placeholder="ค้นหา...">
  </div>

<table class="table  text-center" id="dataTable">
<thead>
  <tr>
    <th scope="col" class="col-2">ชื่อห้อง</th>
    <th scope="col" class="col-2">ประเภทห้อง</th>
    <th scope="col" class="col-2">วันที่ทำการจอง</th>
    <th scope="col" class="col-2">เวลาในการจอง</th>
    <th scope="col" class="col">สถานะห้อง</th>
    
  </tr>
</thead>
<tbody>
    @foreach ($book_details as $items)
    @if ($items->booking->status_book != 'รอยืนยันการจอง')
    <tr>
        <td data-label="ชื่อห้อง">{{$items->booking->work_time->listRoom->name_room}}</td>
        <td data-label="ประเภทห้อง">{{$items->booking->work_time->listRoom->typeRoom->name_type}}</td>
        <td data-label="วันที่ทำการจอง" >{{ $items->booking->created_at->toDateString() }}</td>
        <td data-label="เวลาในการจอง">{{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</td>
        <td class="form-css" data-label="สถานะห้อง">{{$items->booking->status_book}} </td>
    </tr>
    @endif    
@endforeach
</tbody>
</table>
{{ $book_details->withQueryString()->links('pagination::bootstrap-4') }}
</div>
<script src="{{asset('js/User/history.js')}}"></script>
@endsection