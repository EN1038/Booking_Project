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
        title: 'รหัสผ่านผิด!',
        text: 'รหัสผ่านผิดอะ',
        icon: 'error'
    });
    </script>
@endif

    <div class="container my-3">
        <p class="fs-1 fw-bold text-center">Page Login</p>
        <form action="{{route('insert_login')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="passwordNumber_user" class="form-label">รหัสประจำตัว</label>
                <input type="passwordNumber_user" class="form-control" id="passwordNumber_user" placeholder="กรอกรหัสประจำตัว" name="passWordNumber_user">
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="กรอกรหัสผ่าน" name="password">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Login</button>
                <a href="{{route('register')}}" class="btn btn-secondary">Register Page</a>
            </div>
        </form>
    </div>
@endsection