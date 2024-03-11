@extends('Layout.layout_admin.layout')
@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
            <h1>สร้างห้อง</h1>
            <div class="col-12 d-flex flex-row justify-content-end align-items-center">
                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#createRooms">
                    สร้างห้อง
                </button>
                <a href="{{route('create_typeroom')}}" type="button" class="btn btn-secondary m-1">
                    สร้างประเภทห้อง
                </a>
            </div>
            <div class="col-12 px-4">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
            

    </div>
    {{-- modal create rooms --}}
    <div class="modal fade" id="createRooms" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">สร้างห้อง</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" method="POST">
                <div class="mb-3">
                    <label for="nameRooms" class="form-label">กรอกชื่อห้อง</label>
                    <input type="text" class="form-control" id="nameRooms" name="nameRoom" placeholder="กรอกชื่อห้องที่ต้องการ">
                </div>
                <div class="mb-3">
                    <label for="numPeople" class="form-label">กรอกจำนวนคนที่สามารถเข้าใช้งานได้</label>
                    <input type="int" class="form-control" id="numPeople" name="numPeople" placeholder="กรอกจำนวนคน">
                </div>
                <label for="typeRooms" class="form-label">เลือกประเภทห้อง</label>
                <select class="form-select">
                    <option selected disabled hidden>ประเภทห้อง</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
              <button type="submit" class="btn btn-primary">สร้างห้อง</button>
            </div>
            </form>
          </div>
        </div>
      </div>    
@endsection