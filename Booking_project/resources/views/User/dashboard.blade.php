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
<link rel="stylesheet" href="{{asset('css/Admin/ิbooking_admin.css')}}">
<div class="container text-center " id="hideDiv">
<div class="row">
    <h1 class="text-center fw-bold text-greenlight mb-3"><i class="fa-solid fa-bookmark fs-2"></i> จองห้อง</h1>
    <div class="d-flex flex-row justify-content-center my-4">
      <div class="col"><i class="fa-solid fa-bookmark text-info fs-2"></i><p class="mx-4 fs-5">สีฟ้า : ห้องเปิดการจองออนไลน์</p></div>
      <div class="col"><i class="fa-solid fa-bookmark text-warning fs-2"></i><p class="mx-4 fs-5">สีส้ม : ห้องต้องว็อกอินเข้าไปจอง</p></div>
      <div class="col"><i class="fa-solid fa-bookmark text-secondary fs-2"></i><p class="mx-4 fs-5">สีเทา : ห้องหมดเวลาการจอง</p></div>
    </div>
  @foreach ($typeRoom as $type_room)
    <p class="fs-2 fw-bold text-greenlight my-3">ประเภทห้อง {{$type_room->name_type}}</p>
    @foreach ($room as $items)
  @if ($items->status_room == 'On' && ($type_room->id == $items->id_type_room))
  <div class="col-md-6 my-2 ">
    <div class="card rounded border-success">
        <div class="row g-0">
            <div class="col-lg-4">
                <div class="image-container" style="height: 270px;">
                  <img src="{{ Storage::url('img/' . $items->image_room) }}" class="full-size-image rounded-start" alt="">
                </div>
            </div>
            <div class="col-lg-8">
              <div class="card-body">
                  <p class="card-title fs-3 fw-bold">{{$items->name_room}}</p>
                  <div class="row mt-1 pt-2 mx-1 d-flex flex-row justify-content-evenly">
                      @php $loopCount = 0; @endphp
                      @foreach ($work_times as $time)
                          @if ($items->id == $time->id_room)
                              @php $loopCount++; @endphp
                              <button class="col-3 btn text-light rounded-4 m-1 mb-2 btn-custome
                                  {{ $time->status_wt === 'จองห้อง' ? 'btn-info' : ($time->status_wt === 'หมดเวลาจอง' ? 'btn-secondary' : 'btn-warning') }}" 
                                  style="cursor: default; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                  {{ date('H', strtotime($time->name_start_workTime)) !== '00' ? date('H', strtotime($time->name_start_workTime)) . ':' : '' }}
                                  {{ substr(date('i', strtotime($time->name_start_workTime)), -2) }}
                              </button>
                          @endif
                      @endforeach
                  </div>
              </div>
              @if ($loopCount < 6)
                  <div class="mx-2 my-1 costom-position">
              @elseif ($loopCount > 6)
                  <div class="mx-2 my-1">
              @endif
                      <p class="p-0 m-0 mt-1 text-secondary"><i class="fa-solid fa-circle-info"></i> ยกเลิกการจองก่อน {{ date('H', strtotime($items->typeRoom->time_cancel)) !== '00' ? date('H', strtotime($items->typeRoom->time_cancel)) . ':' : '' }}{{ substr(date('i', strtotime($items->typeRoom->time_cancel)), -2) }} นาที</p>
                      <button type="button" class="btn btn-success w-100 rounded-5 btn-custome" data-bs-toggle="modal" data-bs-target="#listRoom{{$items->id}}">
                          <i class="fa-solid fa-bookmark"></i> ทำการจอง
                      </button>
                  </div>
                  <style>
                    .costom-position{
                      position: absolute;
                      bottom: 0;
                      left: 80%;
                      transform: translateX(-72%);
                      width: 64%;
                    }

                    @media (max-width: 991px) {
                        .costom-position {
                            position: relative;
                            bottom: auto;
                            left: auto;
                            transform: none;
                            width: auto;
                        }
                    }
                </style>
              
          </div>
          
        </div>
    </div>
  </div>
  
  @endif
  
  @endforeach
  @endforeach
  
</div>
</div>
<div class="d-none text-center mt-5 " id="showDiv">
  <h1 class="text-greenlight ">ระบบจะเปิดเมื่อเวลา 8:00 โมงเช้า</h1>
  <p class="text-secondary fs-5" id="currentTime"></p>
</div>
@foreach ($room as $items)
<!-- Modal -->
<div class="modal fade" id="listRoom{{$items->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
  <div class="modal-header">
    <h1 class="modal-title fs-5 fw-bold text-greenlight" id="exampleModalLabel">{{$items->name_room}}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <form action="{{route('insert_booking_admin',$items->id)}}" method="POST">
      @csrf
      <div class="mb-3">
        <p class="text-danger p-0 m-0"><i class="fa-solid fa-circle-info"></i> การเข้าห้องสายหรือไม่มาครบ 3 ครั้ง</p>
        <p class="text-danger p-0 m-0"><i class="fa-solid fa-circle-info"></i> จะไม่สามารถเข้าใช้การจองออนไลน์ 3 เดือน</p>
      </div>
      <div class="mb-3">
        <input type="text" class="form-control mb-1" name="id_room" value="{{$items->id}}" readonly hidden>
        <label for="exampleInputEmail1" class="form-label rounded-5">กรอกชื่อ {{$items->typeRoom->number_user}} คนเพื่อทำการจอง</label>
        <input type="text" class="form-control mb-1" id="nameone" name="pass_number[]" value="{{Auth::user()->passWordNumber_user;}}" readonly>
        @for ($i = 1; $i < $items->typeRoom->number_user; $i++)
        <input type="text" class="form-control mb-1 text-center rounded-5" id="nameone" placeholder="ใส่ชื่อคนที่ {{$i+1}}" name="pass_number[]" >
        @endfor
      </div>
      <label for="chooseTime" class="form-label">โปรดเลือกเวลาที่จะทำการจอง</label>
      <select class="form-select text-center rounded-5" aria-label="Default select example" name="select_time">
        <option selected hidden disabled>เลือกเวลา</option>
        @foreach ($work_times as $time)
        @if ($items->id == $time->id_room && $time->status_wt == 'จองห้อง')
          <option value="{{$time->id}}">{{ date('H', strtotime($time->name_start_workTime)) !== '00' ? date('H', strtotime($time->name_start_workTime)) . ' : ' : '' }}
            {{ substr(date('i', strtotime($time->name_start_workTime)), -2) }} ถึง {{ date('H', strtotime($time->name_end_workTime)) !== '00' ? date('H', strtotime($time->name_end_workTime)) . ' : ' : '' }}
            {{ substr(date('i', strtotime($time->name_end_workTime)), -2) }}
            
            
          </option>
        @endif
    @endforeach
      </select>
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary rounded-5" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i> ปิด</button>
    <button type="submit" class="btn btn-success rounded-5"><i class="fa-solid fa-bookmark"></i> ทำการจอง</button>
  </div>
</form>
</div>
</div>
</div>

<script src="{{asset('js/User/dashboard.js')}}"></script>
@endforeach
@endsection