@extends('Layout.layout_admin.layout')
@section('content')
@if(session('success'))
    <script>
        Swal.fire({
            title: 'บันทึกข้อมูลเรียบร้อย!',
            text: 'ข้อมูลได้ถูกบันทึกเรียบร้อยแล้ว',
            icon: 'success'
        });
    </script>
@elseif (session('error'))
    <script>
        Swal.fire({
        title: 'ไม่สามารถบันทึกข้อมูลได้!',
        text: 'ข้อมูลที่ส่งมาไม่มีค่าในระบบ',
        icon: 'error'
    });
    </script>
@endif
@if (count($type_rooms)>0)
<div class="d-flex flex-column justify-content-center align-items-center">
  <h1>สร้างประเภทห้อง</h1>
  <div class="col-12 d-flex flex-row justify-content-end align-items-center">
      <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#createTypeRooms">
          สร้างประเภท
      </button>
  </div>
  <div class="col-12 px-4">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">ชื่อประเภท</th>
              <th scope="col">ระยะเวลาการใช้งาน</th>
              <th scope="col">จำนวนคนขั้นต่ำ</th>
              <th scope="col">อื่นๆ</th>
            </tr>
          </thead>
          @foreach ($type_rooms as $items)
          <tbody> 
            <tr>
              <td>{{$items->name_type}}</td>
              <td>{{$items->time_duration}}</td>
              <td>{{$items->number_user}}</td>
              <td>
                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editTypeRooms{{$items->id}}">
                  แก้ไข
              </button>
                  <a href="{{route('delete_type_rooms',$items->id)}}" class="btn btn-danger" onclick="return confirmDelete(event)">ลบ</a>
              </td>
            </tr>
          </tbody>
          @endforeach
        </table> 
        {{$type_rooms->links()}}
        
  </div>
  

</div>
@else
<h1 class="text-center">ไม่มี้จา</h1>
@endif

{{-- modal create type rooms --}}
<div class="modal fade" id="createTypeRooms" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">สร้างประเภทห้อง</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
    </div>
    <div class="modal-body">
      <form action="{{route('insert_typeroom')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nameTypeRooms" class="form-label">ชื่อประเภทห้อง</label>
            <input type="text" class="form-control text-center" id="nameTypeRooms" name="nameTypeRooms" placeholder="กรอกชื่อประเภทห้องที่ต้องการ">
            <label for="errornameTypeRooms" class="form-label mx-3 text-danger fw-bold" id="errornameTypeRooms"></label>
        </div>
        <div class="mb-3">
            <label for="numTypeRooms" class="form-label">จำนวนคนขั้นต่ำในการเข้าใช้งาน</label>
            <input type="number" class="form-control text-center" name="numberUser" placeholder="กรอกจำนวนคน" step="1" id="numberUser">
            <label for="ErrorNumUser" class="form-label mx-3 text-danger fw-bold" id="errorNumberUser"></label>
        </div>
        <div class="mb-3">
          <label for="timeDuration" class="form-label">เวลาในการใช้งานของประเภทนี้</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
              <input type="number" class="form-control text-center" id="hourInput" placeholder="กรอกชั่วโมง" step="1">
              <label for="hourDuration" class="form-label mx-3">ชั่วโมง</label>
              <input type="number" class="form-control text-center" id="minuteInput" placeholder="กรอกนาที" step="1">
              <label for="minuteDuration" class="form-label mx-3">นาที</label>
              
          </div>
          <label for="ErrorTime" class="form-label mx-3 text-danger fw-bold" id="ErrorTime"></label>
          <input type="time" class="form-control" id="trueTime" name="trueTime" hidden>      
        </div>
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary d-none rounded-5" id="buttonCreate" disabled>สร้างประเภทห้อง</button>
        <button type="button" class="btn btn-secondary d-none rounded-5" id="buttonUndu" onclick="UndoValue()">กรอกค่าใหม่</button>
        <button type="button" class="btn btn-success rounded-5" id="buttonConfirm" onclick="conFirmCreateTypeRoom()">ตรวจสอบ</button>
        <button type="button" class="btn btn-danger rounded-5" data-bs-dismiss="modal" id="bottomClose">ปิด</button>
      </div> 
    </form>
  </div>
  </div>
</div>


  {{-- modal edits type rooms --}}
@foreach ($type_rooms as $items)
<div class="modal fade" id="editTypeRooms{{$items->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขประเภทห้องชื่อ {{$items->name_type}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('edit_type_rooms',$items->id)}}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="nameTypeRooms" class="form-label">แก้ไขชื่อประเภทห้อง</label>
            <input type="text" class="form-control text-center" id="editNameTypeRooms{{$items->id}}" name="editNameTypeRooms" data-id="{{$items->id}}" placeholder="กรอกชื่อประเภทห้องที่ต้องการ" onchange="validate_EditNameTypeRoom()">
            <label for="errornameTypeRooms" class="form-label mx-3 text-danger fw-bold" id="editErrornameTypeRooms{{$items->id}}"></label>
        </div>
        <div class="mb-3">
            <label for="numTypeRooms" class="form-label">แก้ไขจำนวนคนขั้นต่ำในการเข้าใช้งาน</label>
            <input type="number" class="form-control text-center" name="editNumberUser" placeholder="กรอกจำนวนคน" step="1" id="editNumberUser{{$items->id}}" data-id="{{$items->id}}" onchange="validate_EditNumberUser()">
            <label for="ErrorNumUser" class="form-label mx-3 text-danger fw-bold" id="editErrorNumberUser{{$items->id}}"></label>
        </div>
        <div class="mb-3">
          <label for="timeDuration" class="form-label">แก้ไขเวลาในการใช้งานของประเภทนี้</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
              <input type="number" class="form-control text-center" id="editHourInput{{$items->id}}" data-id="{{$items->id}}" placeholder="กรอกชั่วโมง" step="1" onchange="combineTimeEdit()">
              <label for="hourDuration" class="form-label mx-3">ชั่วโมง</label>
              <input type="number" class="form-control text-center" id="editMinuteInput{{$items->id}}" data-id="{{$items->id}}" placeholder="กรอกนาที" step="1" onchange="combineTimeEdit()">
              <label for="minuteDuration" class="form-label mx-3">นาที</label>
              
          </div>
          <label for="ErrorTime" class="form-label mx-3 text-danger fw-bold" id="editErrorTime{{$items->id}}"></label>
          <input type="time" class="form-control" id="editTrueTime{{$items->id}}" name="editTrueTime" hidden>      
        </div>
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary rounded-5" disabled id="editButtonCreate{{$items->id}}">สร้างประเภทห้อง</button>
      </div> 
      </form>
    </div>
  </div>
  </div>
@endforeach


<script src="{{asset('js/Admin/type_room.js')}}"></script>
@endsection