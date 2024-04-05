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
{{Auth::user()->name_user;}}
  <div class="container text-center">
    <div class="row">
      @foreach ($room as $items)
      @if ($items->status_room == 'On')
      <div class="col-4  ">
        <div class="card">
          <img src="https://d27jswm5an3efw.cloudfront.net/app/uploads/2019/07/insert-image-html.jpg" class="card-img-top " alt="...">
          <div class="card-body">
            <p class="card-text">{{$items->name_room}}</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#listRoom{{$items->id}}">
              ทำการจอง
            </button>
            <div class="row p-1">
              @foreach ($work_times as $time)
                @if ($items->id == $time->id_room)
                  <button class="col btn btn-info text-light rounded-4 m-1" style="cursor: default;">{{$time->name_start_workTime}}</>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
      @endif
      
      @endforeach
    </div>
  </div>

  @foreach ($room as $items)
    <!-- Modal -->
<div class="modal fade" id="listRoom{{$items->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$items->name_room}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('booking_rooms',$items->id)}}" method="POST">
          @csrf
          <div class="mb-3">
            <input type="text" class="form-control mb-1" name="id_room" value="{{$items->id}}" readonly hidden>
            <label for="exampleInputEmail1" class="form-label">กรอกชื่อ {{$items->typeRoom->number_user}} คนเพื่อทำการจอง</label>
            <input type="text" class="form-control mb-1" id="nameone" name="pass_number[]" value="{{Auth::user()->passWordNumber_user;}}" readonly>
            @for ($i = 1; $i < $items->typeRoom->number_user; $i++)
            <input type="text" class="form-control mb-1" id="nameone" placeholder="ใส่ชื่อคนที่ {{$i+1}}" name="pass_number[]" >
            @endfor
          </div>
          <label for="chooseTime" class="form-label">โปรดเลือกเวลาที่จะทำการจอง</label>
          <select class="form-select" aria-label="Default select example" name="select_time">
            <option selected hidden disabled>เลือกเวลา</option>
            @foreach ($work_times as $time)
            @if ($items->id == $time->id_room)
              <option value="{{$time->id}}">{{$time->name_start_workTime}}-{{$time->name_end_workTime}}</option>
            @endif
        @endforeach
          </select>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary">ทำการจอง</button>
      </div>
    </form>
    </div>
  </div>
</div>
  @endforeach

@endsection