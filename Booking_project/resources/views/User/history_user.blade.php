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
        <td>{{$items->booking->work_time->listRoom->name_room}}</td>
        <td>{{$items->booking->work_time->listRoom->typeRoom->name_type}}</td>
        <td>{{ $items->booking->created_at->toDateString() }}</td>
        <td>{{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</td>
        <td>{{$items->booking->status_book}} </td>
    </tr>
    @endif    
@endforeach
</tbody>
</table>
@endsection