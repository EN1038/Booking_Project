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
<link rel="stylesheet" href="{{asset('css/Admin/create_room.css')}}">
  @if (count($room)>0)
  <div class="row">
    <h1 class="text-center fw-bold text-greenlight ">สร้างห้อง</h1>
    <div class="col-12 d-flex flex-row justify-content-end align-items-center">
        <button type="button" class="btn btn-primary m-1 rounded-5" data-bs-toggle="modal" data-bs-target="#createRooms">
          <i class="fa-solid fa-plus"></i> สร้างห้อง
        </button>
    </div>
    @foreach ($room as $items)
    <div class="col-md-6 col-xl-4 mt-1">
      <div class="card shadow bg">
        <div class="card-body">
          <h5 class="card-title">ชื่อห้อง <span>{{$items->name_room}}</span> <a href="{{route('view_listroom',$items->id)}}"> <i class="fa-solid fa-up-right-from-square text-info fs-5"></i></a></h5>
          <p class="card-text">ประเภทห้อง <span>{{$items->typeRoom->name_type}}</span></p>               
          <p class="card-text">ห้องถูกสร้างเมื่อ <span>{{$items->created_at->toDateString()}}</span></p>               
                <a href="{{route('change_status',$items->id)}}" class="rounded-5 btn {{ $items->status_room === 'On' ? 'btn-success' : 'btn-danger' }}">
                  <i class="fa-solid fa-power-off"></i> {{ $items->status_room }}</a>
                  <a href="{{route('delete_room',$items->id)}}" class="btn btn-danger rounded-5" onclick="return confirmDelete(event)"><i class="fa-solid fa-trash-arrow-up"></i> ลบ</a>
                  <button class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#updateRooms{{$items->id}}"><i class="fa-solid fa-gear"></i> แก้ไข</button>
              </a>
        </div>
      </div>
    </div>
    @endforeach
    {{$room->links()}} 
  </div>

  @else
    <h1 class="text-center">ไม่มี้จา</h1>
    <div class="col-12 d-flex flex-row justify-content-end align-items-center">
      <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#createRooms">
          สร้างห้อง
      </button>
      <a href="{{route('create_typeroom')}}" type="button" class="btn btn-secondary m-1">
          สร้างประเภทห้อง
      </a>
  </div>
 
  @endif
    
    {{-- modal create rooms --}}
    <div class="modal fade" id="createRooms" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">สร้างห้อง</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{route('insert_room')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nameRooms" class="form-label">กรอกชื่อห้อง</label>
                    <input type="text" class="form-control text-center" id="nameRooms" name="nameRoom" placeholder="กรอกชื่อห้องที่ต้องการ" oninput="validationName()">
                    <label for="errorNameRoom" class="form-label mx-3 text-danger fw-bold" id="errorNameRoom"></label>
                </div>
                <label for="typeRooms" class="form-label">เลือกประเภทห้อง</label>
                <select class="form-select text-center" id="select_typeRoom" name="type_room" onchange="showDurationTime()">
                  <option selected disabled hidden>ประเภทห้อง</option>
                  @foreach ($type_rooms as $items)
                    <option value="{{$items->id}}" data-timeDuration="{{$items->time_duration}}">{{$items->name_type}}</option>
                  @endforeach
                </select>
                <label for="errorSelectType" class="form-label mx-3 text-danger fw-bold" id="errorSelectType"></label>
                <div class="mb-3 my-3">
                  <label for="time_duration" class="form-label">ระยะเวลาการทำงานของประเภทนี้ (ชั่วโมง:นาที)</label>
                  <input type="text" class="form-control text-center" id="time_duration" readonly >
                </div>
                <label for="time_working" class="form-label d-none" id="time_working">เวลาเริ่มทำงานของห้อง เวลาเริ่ม 8:30 เวลาสิ้นสุด 16:30</label>
                <div class="row justify-content-center align-items-center" id="fild_timeDuration" >
                </div>
                <label for="status_room" class="form-label">สถานะห้องเริ่มต้น</label>
                <select name="status_room" class="form-select text-center" id="selectStatus" onchange="validateSelectStatus()">
                  <option value="title" selected disabled hidden>เลือกสถานะของห้อง</option>
                  <option value="On">ทำงาน</option>
                  <option value="Off">ปิดการทำงาน</option>
                </select>
                <label for="errorSelectStatus" class="form-label mx-3 text-danger fw-bold" id="errorSelectStatus" ></label>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> ปิด</button>
              <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> สร้างห้อง</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    
    @foreach ($room as $items)
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
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> ปิด</button>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> สร้างห้อง</button>
          </div>
          </form>
        </div>
      </div>
  </div>
    @endforeach
    {{-- update --}}
    

     
      

      <script src="{{asset('js/Admin/room.js')}}"></script>
@endsection