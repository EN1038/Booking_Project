@extends('Layout.layout_user.layout')
@section('content')
{{Auth::user()->name_user;}}
  <div class="container text-center">
    <div class="row">
      @foreach ($room as $items)
      <div class="col-4  ">
        <div class="card">
          <img src="https://d27jswm5an3efw.cloudfront.net/app/uploads/2019/07/insert-image-html.jpg" class="card-img-top " alt="...">
          <div class="card-body">
            <p class="card-text">{{$items->name_room}}</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#listRoom{{$items->id}}">
              ทำการจอง
            </button>
          </div>
        </div>
      </div>
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
        <form action="" method="POST">
          {{$items->typeRoom->number_user}}
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">กรอกชื่อคน</label>
            @for ($i = 0; $i < $items->typeRoom->number_user; $i++)
            <input type="text" class="form-control" id="nameone" >
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            @endfor
          </div>
          
          
        </form>
        @foreach ($work_times as $time)
            @if ($items->id == $time->id_room)
              {{$time->name_start_workTime}}-{{$time->name_end_workTime}}
            @endif
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  @endforeach

@endsection