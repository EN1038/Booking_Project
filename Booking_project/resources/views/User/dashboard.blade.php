@extends('Layout.layout_user.layout')
@section('content')

<div class="col-12 px-4">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">ชื่อห้อง</th>
            <th scope="col">เวลาการทำงาน</th>
            <th scope="col">สถานะของห้อง</th>
            <th scope="col">ประเภทของห้อง</th> 
          </tr>
        </thead>
        @foreach ($room as $items)
        @if ($items->status_room === 'On')
        <th>{{$items->id}}</th>
        <td>{{$items->name_room}}</td>
        <td>{{$items->time_working}}</td>
        <td><a class="btn {{ $items->status_room === 'On' ? 'btn-success' : 'd-none' }}">
          {{ $items->status_room }}
        </a></td>
  
        <td>{{$items->typeRoom->name_type}}</td>
        @else
            {{-- ว่าง --}}
        @endif
        <tbody>
          <tr>
            
          </tr>
        </tbody>
        @endforeach
      </table>
</div>
@endsection