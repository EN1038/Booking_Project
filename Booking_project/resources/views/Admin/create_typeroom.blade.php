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
                <th scope="col">อื่นๆ</th>
              </tr>
            </thead>
            @foreach ($type_rooms as $items)
            <tbody> 
              <tr>
                <td>{{$items->name_type}}</td>
                <td>{{$items->time_duration}}</td>
                <td>
                    <a href="#" class="btn btn-primary">แก้ไข</a>
                    <a href="{{route('delete_type_rooms',$items->id)}}" class="btn btn-danger" onclick="return confirmDelete(event)">ลบ</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table> 
          
    </div>
    

</div>
{{-- modal create type rooms --}}
<div class="modal fade" id="createTypeRooms" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">สร้างห้อง</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="{{route('insert_typeroom')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nameTypeRooms" class="form-label">ชื่อประเภทห้อง</label>
            <input type="text" class="form-control text-center" id="nameTypeRooms" name="nameTypeRooms" placeholder="กรอกชื่อประเภทห้องที่ต้องการ">
        </div>
        <label for="timeDuration" class="form-label">เวลาในการใช้งานของประเภทนี้</label>
        <select class="form-select text-center" name="selectTimeDuration">
            <option selected disabled hidden class="text-center">เลือกเวลาในการใช้งานของประเภทนี้</option>
            <option value="1" class="text-center">เวลาในการใช้งาน  1  ชั่วโมง</option>
            <option value="2" class="text-center">เวลาในการใช้งาน  2  ชั่วโมง</option>
            <option value="3" class="text-center">เวลาในการใช้งาน  3  ชั่วโมง</option>
            <option value="4" class="text-center">เวลาในการใช้งาน  4  ชั่วโมง</option>
            <option value="5" class="text-center">เวลาในการใช้งาน  5  ชั่วโมง</option>
            <option value="6" class="text-center">เวลาในการใช้งาน  6  ชั่วโมง</option>
            <option value="7" class="text-center">เวลาในการใช้งาน  7  ชั่วโมง</option>
            <option value="8" class="text-center">เวลาในการใช้งาน  8  ชั่วโมง</option>
            <option value="9" class="text-center">เวลาในการใช้งาน  9  ชั่วโมง</option>
        </select>
        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">สร้างห้อง</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
    </div>
    </form>
  </div>
</div>
</div>

<script src="{{asset('js/type_room.js')}}"></script>
@endsection