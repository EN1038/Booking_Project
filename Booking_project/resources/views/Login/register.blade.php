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
    <div class="container my-3">
        <p class="fs-1 fw-bold text-center">Page Register</p>
        <form action="{{route('insert_register')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name_user" class="form-label">ชื่อที่จะแสดงในระบบ</label>
                <input type="text" class="form-control" id="name_user" placeholder="กรอกชื่อ" name="name_user">
            </div>
            <div class="mb-3">
                <label for="Email1" class="form-label">ใส่อีเมล</label>
                <input type="email" class="form-control" id="Email1" placeholder="ใส่อีเมล" name="email">
              </div>
              <div class="mb-3">
                <label for="select" class="form-label">โปรเลือกระดับ</label>
                <select class="form-select" name="selectStatus">
                    <option selected disabled hidden>เลือกระดับ</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
              </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="กรอกรหัสผ่าน" name="password">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Register</button>
                <a href="{{route('login')}}" class="btn btn-secondary">Login Page</a>
            </div>
        </form>
    </div>
@endsection