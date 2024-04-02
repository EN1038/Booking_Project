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
        <th scope="col">ชื่อห้อง</th>
        <th scope="col">เวลาในการจอง</th>
        <th scope="col">สถานะห้อง</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($book_details as $items)
        <tr>
            <td>{{$items->booking->work_time->listRoom->name_room}}</td>
            <td>{{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</td>
            <td>
                <select class="form-select" onchange="changStatus()" data-status="{{$items->booking->status_book}}" data-id="{{$items->booking_id}}"  {{$items->booking->status_book === 'ยกเลิกการจอง' ? 'disabled' : '' }}>
                    <option value="{{$items->booking->status_book}}" class="text-warning" selected hidden>{{$items->booking->status_book}}</option>
                    <option value="ยกเลิกการจอง" class="text-danger">ยกเลิกการจอง</option>
                  </select>
            </td>
          </tr>
    @endforeach
    </tbody>
  </table>
  <script src="{{asset('js/๊User/statusRoom.js')}}"></script>
@endsection