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
<link rel="stylesheet" href="{{asset('css/Admin/typeRoom.css')}}">
@if (count($type_rooms)>0)
<div class="row">
  <h1 class="text-center fw-bold text-greenlight">สร้างประเภทห้อง</h1>
    <div class="d-flex flex-column justify-content-center align-items-center">
      <div class="col-12 d-flex flex-row justify-content-end align-items-center">
          <button type="button" class="btn btn-success m-1 rounded-5" data-bs-toggle="modal" data-bs-target="#createTypeRooms">
            <i class="fa-solid fa-plus"></i> สร้างประเภท
          </button>
      </div>
    </div>
    @foreach ($type_rooms as $items)
    <div class="col-xl-6 mt-1">
      <div class="card bg">
        <div class="card-body">
          <h5 class="card-title">ชื่อประเภท <span>{{$items->name_type}}</span></h5>
          <p class="card-text">ระยะเวลาการใช้งาน <span>{{ date('H', strtotime($items->time_duration)) !== '00' ? date('H', strtotime($items->time_duration)) . ' ชั่วโมง ' : '' }}{{ substr(date('i', strtotime($items->time_duration)), -2) }} นาที</span></p>               
          <p class="card-text">เวลาก่อนยกเลิกการจอง <span>{{ date('H', strtotime($items->time_cancel)) !== '00' ? date('H', strtotime($items->time_cancel)) . ' ชั่วโมง ' : '' }}{{ substr(date('i', strtotime($items->time_cancel)), -2) }} นาที</span></p>               
          <p class="card-text">เวลาเข้าสาย <span>{{ date('H', strtotime($items->time_late)) !== '00' ? date('H', strtotime($items->time_late)) . ' ชั่วโมง ' : '' }}{{ substr(date('i', strtotime($items->time_late)), -2) }} นาที</span></p>               
          <p class="card-text">จำนวนคนขั้นต่ำ <span>{{$items->number_user}} คน</span></p> 
          <div class="col-12 d-flex flex-row justify-content-end align-items-center">
            <a href="{{route('create_room',$items->id)}}" class="btn btn-success rounded-5 mx-1" ><i class="fa-solid fa-folder-open"></i> รายการห้อง</a>
            <button type="button" class="btn btn-primary m-1 rounded-5" data-bs-toggle="modal" data-bs-target="#editTypeRooms{{$items->id}}">
              <i class="fa-solid fa-gear"></i> แก้ไข
              </button>
            <a href="{{route('delete_type_rooms',$items->id)}}" class="btn btn-danger rounded-5 mx-1" onclick="return confirmDelete(event)"><i class="fa-solid fa-trash-arrow-up"></i> ลบ</a>
          </div>             
        </div>
      </div>
    </div>
    @endforeach
  {{$type_rooms->withQueryString()->links('pagination::bootstrap-4')}} 
</div>
@else
<h1 class="text-center">ไม่มี้จา</h1>
<div class="col-12 d-flex flex-row justify-content-end align-items-center">
  <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#createTypeRooms">
      สร้างประเภท
  </button>
</div>
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
        <div class="mb-3">
          <label for="timeBeforCancel" class="form-label">เวลาในการยกเลิกการจอง</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
            <input type="number" class="form-control text-center" id="timeBeforCancel" name="timeBeforCancel" placeholder="กรอกเวลาในการยกเลิกการจอง"> 
            <label for="minuteDuration" class="form-label mx-3">นาที</label>
          </div> 
          <label for="ErrorTimeCancel" class="form-label mx-3 text-danger fw-bold" id="ErrorTimeCancel"></label>
          <input type="time" class="form-control" id="trueTimeCancel" name="trueTimeCancel" hidden>
        </div>
        <div class="mb-3">
          <label for="timeBeforCancel" class="form-label">เวลาในการมาสาย</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
            <input type="number" class="form-control text-center" id="timeBeforLate" name="timeBeforLate" placeholder="กรอกเวลาในการยกเลิกการจอง"> 
            <label for="minuteDuration" class="form-label mx-3">นาที</label>
          </div> 
          <label for="ErrorTimeCancel" class="form-label mx-3 text-danger fw-bold" id="ErrorTimeLate"></label>
          <input type="time" class="form-control" id="trueTimeLate" name="trueTimeLate" hidden>
        </div>
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary d-none rounded-5" id="buttonCreate" disabled><i class="fa-solid fa-plus"></i> สร้างประเภทห้อง</button>
        <button type="button" class="btn btn-secondary d-none rounded-5" id="buttonUndu" onclick="UndoValue()"> กรอกค่าใหม่</button>
        <button type="button" class="btn btn-success rounded-5" id="buttonConfirm" onclick="conFirmCreateTypeRoom()">ตรวจสอบ</button>
        <button type="button" class="btn btn-danger rounded-5" data-bs-dismiss="modal" id="bottomClose"><i class="fa-solid fa-circle-xmark"></i> ปิด</button>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขประเภทห้องชื่อ <span class="text-greenlight fs-4">{{$items->name_type}}</span></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('edit_type_rooms',$items->id)}}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="nameTypeRooms" class="form-label">แก้ไขชื่อประเภทห้อง</label>
            <input type="text" class="form-control text-center" id="editNameTypeRooms{{$items->id}}" name="editNameTypeRooms" data-id="{{$items->id}}" value="{{$items->name_type}}" placeholder="{{$items->name_type}}" onchange="validate_EditNameTypeRoom()">
            <label for="errornameTypeRooms" class="form-label mx-3 text-danger fw-bold" id="editErrornameTypeRooms{{$items->id}}"></label>
        </div>
        <div class="mb-3">
            <label for="numTypeRooms" class="form-label">แก้ไขจำนวนคนขั้นต่ำในการเข้าใช้งาน</label>
            <input type="number" class="form-control text-center" name="editNumberUser" value="{{$items->number_user}}" placeholder="{{$items->number_user}}" step="1" id="editNumberUser{{$items->id}}" data-id="{{$items->id}}" onchange="validate_EditNumberUser()">
            <label for="ErrorNumUser" class="form-label mx-3 text-danger fw-bold" id="editErrorNumberUser{{$items->id}}"></label>
        </div>
        <div class="mb-3">
          <label for="timeDuration" class="form-label mb-0">แก้ไขเวลาในการใช้งานของประเภทนี้</label>
          <label for="timeDurationAlert" class="form-label text-danger fs-7 my-0"><i class="fa-solid fa-circle-exclamation"></i> เวลานี้จะถูกใช้งานเฉพาะห้องที่สร้างใหม่เท่านั้น</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
              <input type="number" class="form-control text-center" id="editHourInput{{$items->id}}" data-id="{{$items->id}}" value="{{ date('H', strtotime($items->time_duration)) == '00' ? '0' : ltrim(date('H', strtotime($items->time_duration)), '0') }}" placeholder="{{ date('H', strtotime($items->time_duration)) == '00' ? '0' : ltrim(date('H', strtotime($items->time_duration)), '0') }}" step="1" onchange="combineTimeEdit()">
              <label for="hourDuration" class="form-label mx-3">ชั่วโมง</label>
              <input type="number" class="form-control text-center" id="editMinuteInput{{$items->id}}" data-id="{{$items->id}}" value="{{ date('i', strtotime($items->time_duration)) == '00' ? '0' : ltrim(date('i', strtotime($items->time_duration)), '0') }}" placeholder="{{ date('i', strtotime($items->time_duration)) == '00' ? '0' : ltrim(date('i', strtotime($items->time_duration)), '0') }}" step="1" onchange="combineTimeEdit()">
              <label for="minuteDuration" class="form-label mx-3">นาที</label>
              
          </div>
          <label for="ErrorTime" class="form-label mx-3 text-danger fw-bold" id="editErrorTime{{$items->id}}"></label>
          <input type="time" class="form-control" id="editTrueTime{{$items->id}}" value="{{$items->time_duration}}" name="editTrueTime" hidden>      
        </div>
        <div class="mb-3">
          <label for="timeBeforCancel" class="form-label">เวลาในการยกเลิกการจอง</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
            <input type="number" class="form-control text-center" id="timeEditBeforCancel{{$items->id}}" name="timeEditBeforCancel" data-id="{{$items->id}}" value="{{ date('i', strtotime($items->time_cancel)) == '00' ? '0' : ltrim(date('i', strtotime($items->time_cancel)), '0') }}" placeholder="{{ date('i', strtotime($items->time_cancel)) == '00' ? '0' : ltrim(date('i', strtotime($items->time_cancel)), '0') }}" onchange="convertEditMinutesToTime()"> 
            <label for="minuteDuration" class="form-label mx-3">นาที</label>
          </div> 
          <label for="ErrorTimeCancel" class="form-label mx-3 text-danger fw-bold" id="ErrorEditTimeCancel{{$items->id}}"></label>
          <input type="time" class="form-control" id="trueEditTimeCancel{{$items->id}}" name="trueEditTimeCancel" value="{{$items->time_cancel}}" hidden>
        </div>
        <div class="mb-3">
          <label for="timeBeforCancel" class="form-label">เวลาในการเข้าสาย</label>
          <div class="d-flex flex-row justify-contents-center align-items-center">
            <input type="number" class="form-control text-center" id="timeEditBeforLate{{$items->id}}" name="timeEditBeforLate" data-id="{{$items->id}}" value="{{ date('i', strtotime($items->time_late)) == '00' ? '0' : ltrim(date('i', strtotime($items->time_late)), '0') }}" placeholder="{{ date('i', strtotime($items->time_late)) == '00' ? '0' : ltrim(date('i', strtotime($items->time_late)), '0') }}" onchange="convertEditMinutesToTimeLate()"> 
            <label for="minuteDuration" class="form-label mx-3">นาที</label>
          </div> 
          <label for="ErrorTimeCancel" class="form-label mx-3 text-danger fw-bold" id="ErrorEditTimeLate{{$items->id}}"></label>
          <input type="time" class="form-control" id="trueEditTimeLate{{$items->id}}" name="trueEditTimeLate" value="{{$items->time_late}}" hidden>
        </div>
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary rounded-5" disabled id="editButtonCreate{{$items->id}}"><i class="fa-solid fa-plus"></i> แก้ไขประเภทห้อง</button>
      </div> 
      </form>
    </div>
  </div>
  </div>
@endforeach


<script src="{{asset('js/Admin/type_room.js')}}"></script>
@endsection