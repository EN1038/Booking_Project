@extends('Layout.layout_admin.layout')
@section('content')

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
        @foreach ($book_details as $items)
        <tbody> 
          <tr>
            <td>{{$items->Leveluser->name_user}}</td>
            <td>{{$items->booking->work_time->listRoom->name_room}}</td>
            <td>{{$items->booking->work_time->listRoom->typeRoom->name_type}}</td>
            <td>{{$items->booking->work_time->name_start_workTime}}-{{$items->booking->work_time->name_end_workTime}}</td>
            <td><button class="btn btn-primary">{{$items->booking->status_book}}</button> </td>
          </tr>
        </tbody>
        @endforeach
      </table> 


      
</div>
@endsection