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
        <p class="fs-1 fw-bold text-center">Page Login</p>
        <form action="{{route('insert_login')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name_user" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="กรอกชื่อ" name="email">
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="กรอกรหัสผ่าน" name="password">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Login</button>
                <a href="{{route('register')}}" class="btn btn-secondary">Register Page</a>
            </div>
        </form>
    </div>
@endsection