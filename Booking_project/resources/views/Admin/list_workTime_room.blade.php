@extends('Layout.layout_admin.layout')
@section('content')
<div class="row">
  <h1 class="text-center fw-bold text-greenlight">เวลาที่ห้องเปิดให้จอง</h1>
  <h2 class="text-center fw-bold mb-3">ห้อง {{$room->name_room}} ประเภทห้อง {{$room->typeRoom->name_type}}</h2>
  @foreach ($workTimes as $items)
  <div class="col-md-6 col-xl-4 mt-3">
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title fw-bold">เวลาที่ {{ $loop->iteration }}</h5>
        <p class="card-text">เวลาการทำงาน <span class="text-success">{{ date('H', strtotime($items->name_start_workTime)) !== '00' ? date('H', strtotime($items->name_start_workTime)) . ' : ' : '' }}{{ substr(date('i', strtotime($items->name_start_workTime)), -2) }}</span> ถึง
        <span class="text-danger">{{ date('H', strtotime($items->name_end_workTime)) !== '00' ? date('H', strtotime($items->name_end_workTime)) . ' : ' : '' }}{{ substr(date('i', strtotime($items->name_end_workTime)), -2) }}</span></p>                          
        <a href="{{route('delete_listroom',$items->id)}}" class="btn btn-danger rounded-5" onclick="return confirmDelete(event)"><i class="fa-solid fa-trash-arrow-up"></i> ลบ</a>
      </div>
    </div>
  </div>
  @endforeach
  {{$workTimes->links()}} 
</div>



<script src="{{asset('js/Admin/listRoom.js')}}"></script>
@endsection