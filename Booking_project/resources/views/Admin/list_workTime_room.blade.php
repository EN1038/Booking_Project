@extends('Layout.layout_admin.layout')
@section('content')
<div class="col-12 px-4">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">ชื่อห้อง</th>
            <th scope="col">เวลาการทำงาน</th>
            <th scope="col">ประเภทของห้อง</th>
            <th scope="col">อื่นๆ</th>
          </tr>
        </thead>
        
        @foreach ($workTimes as $items)
        <tbody>
          <tr>
            <th>{{$items->id}}</th>
            <td>{{$items->listRoom->name_room}}</td>
            <td>
                {{$items->name_start_workTime}} - {{$items->name_end_workTime}}
            </td>
      
            <td>{{$items->listRoom->typeRoom->name_type}}</td>
            <td>
                <a href="{{route('delete_listroom',$items->id)}}" class="btn btn-danger" onclick="return confirmDelete(event)">ลบ</a>
                {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateRooms{{$items->id}}">แก้ไข</button> --}}
            </td>
          </tr>
        </tbody>
        @endforeach
      </table>
</div>

{{-- @foreach ($workTimes as $items)
    <div class="modal fade" id="updateRooms{{$items->id}}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขชื่อห้อง</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('update_room',$items->id)}}" method="POST">
              @csrf
              <div class="mb-3">
                  <label for="nameRooms" class="form-label">กรอกชื่อห้อง</label>
                  <input type="text" class="form-control text-center" id="updateNameRoom" name="updateNameRoom" placeholder="{{$items->name_room}}" oninput="validationName()">
                  <label for="errorNameRoom" class="form-label mx-3 text-danger fw-bold" id="errorNameRoom"></label>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary">สร้างห้อง</button>
          </div>
          </form>
        </div>
      </div>
  </div>
    @endforeach --}}

<script src="{{asset('js/Admin/listRoom.js')}}"></script>
@endsection