@extends('Layout.layout_user.layout')
@section('content')

<div class="d-flex flex-column justify-content-center align-items-center fs-2" style="min-height: 75vh;">
    <i class="fa-solid fa-circle-exclamation text-warning mb-2" style="font-size: 150px"></i>
    <p class="text-danger">คุณ {{$error_user->name_user}}</p>
    <p class="fs-4 text-secondary" >จะมีสิทในการใช้งานระบบจองออนไลน์อีก</p>
    <p id="countdown" class="text-greenlight"></p>
    {{-- <a href="{{route('update_status_user_user',$error_user->id)}}">xx</a> --}}
</div>


<script>
    // ดึงค่าวันที่และเวลาจากตัวแปร Blade
    var coolDownTime = new Date("{{$error_user->cool_down_user}}").getTime();

    // ตั้งค่าวันที่ปัจจุบัน
    var now = new Date().getTime();

    // คำนวณหาระยะเวลาที่ต้องการนับถอยหลัง
    var duration = coolDownTime - now;

    // ตัวแปรสำหรับแสดงผลลัพธ์ของตัวนับเวลา
    var countdownElement = document.getElementById("countdown");

    // ฟังก์ชันสำหรับการอัปเดตและแสดงผลลัพธ์ของตัวนับเวลา
    function updateCountdown() {
        // ถ้าหมดเวลาแล้วให้แสดงข้อความว่า "หมดเวลา"
        if (duration <= 0) {
            countdownElement.innerText = "คุณจะกลับสู่สถานะเข้าใช้งานระบบได้";
            clearInterval(countdownInterval); // หยุดตัวนับเวลา
            var host = 'http://127.0.0.1:8000/';
            var herf = host + 'Update_status_user_User/';
            var id = "{{$error_user->id}}";
            window.location.href = herf + id + '/' + 'จองได้';

        }

        // แปลงเวลาที่เหลือเป็นวัน/ชั่วโมง/นาที/วินาที
        var days = Math.floor(duration / (1000 * 60 * 60 * 24));
        var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((duration % (1000 * 60)) / 1000);

        // แสดงผลลัพธ์ของตัวนับเวลา
        countdownElement.innerText = days + " วัน " + hours + " ชั่วโมง " + minutes + " นาที " + seconds + " วินาที";

        // ลบระยะเวลาที่ผ่านไปไป 1 วินาที
        duration -= 1000;
    }

    // เริ่มตัวนับเวลา
    updateCountdown();
    var countdownInterval = setInterval(updateCountdown, 1000);
</script>
        
@endsection