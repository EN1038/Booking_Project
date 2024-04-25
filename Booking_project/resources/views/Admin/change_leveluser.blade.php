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
    <div class="row justify-content-center align-items-center">
        <div class="d-flex flex-column justify-content-center align-items-center my-5 col-12 ">
            <p class="fs-1 text-greenlight fw-bold">เปลี่ยนระดับผู้ใช้งาน</p>
            <form action="{{route('change_level_user')}}" method="POST" class="w-75">
                @csrf
                <div class="mb-3 w-100 h-100">
                    <label for="passNumberUser" class="form-label">รหัสผู้ใช้งาน</label>
                    <input type="text" class="form-control text-center rounded-5" id="passNumberUser" name="passNumberuser" placeholder="โปรดกรอกรหัสผู้ใช้งาน" onkeyup="check_passNumberUser(this)">
                    <label for="passNumberUser" class="form-label text-danger my-2" id="error_noname"></label>
                </div>
                <label for="select_level_user" class="form-label ">เลือกระดับผู้ใช้งาน</label>
                <select class="form-select text-center rounded-5" aria-label="Default select example" name="select_level">
                    <option selected hidden disabled>เลือกระดับผู้ใช้ที่ต้องการเปลี่ยน</option>
                    <option value="superAdmin">SuperAdmin</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button class="btn btn-success my-3 rounded-5" id="submit" disabled><i class="fa-solid fa-user-plus"></i> ยืนยันการเปลี่ยนระดับผู้ใช้งาน</button>
            </form>
        </div>
    </div>

    <script>

function check_passNumberUser() {
    var input = document.getElementById('passNumberUser');
    var error_noname = document.getElementById('error_noname');
    var submit = document.getElementById('submit');
    fetch('/api/leveluser')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            
            // เช็คว่าข้อมูลใน data มีตัวไหนที่ตรงกับ input หรือไม่
            var match = data.find(item => item.passWordNumber_user === input.value);
            // ถ้ามีข้อมูลที่ตรงกับ input ให้ลบข้อความใน input
            if (match !== undefined) {
                error_noname.textContent = 'มีชื่ออยู่ในระบบสามารถเปลี่ยนระดับได้'
                error_noname.classList.remove('text-danger');
                error_noname.classList.add('text-success');
                submit.disabled = false;
            }else{
                error_noname.textContent = 'ไม่มีชื่ออยู่ในระบบไม่สามารถเปลี่ยนระดับได้'
                error_noname.classList.add('text-danger');
                error_noname.classList.remove('text-success');
                submit.disabled = true;
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}



    </script>


@endsection