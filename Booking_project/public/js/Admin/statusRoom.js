function changStatus() {
    var select = event.target;
    var status_now = event.target.dataset.status;
    var id = event.target.dataset.id;
    var work_time_id = event.target.dataset.work_time_id;
    var host = 'http://127.0.0.1:8000/';
    var herf = host + 'Update_status_admin/';
    if (event.target.value === 'ยืนยันการจอง') {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการที่จะยืนยันรายการนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ยืนยันการจอง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = herf + id + '/' + select.value;
            } else {
                select.value = status_now;
            }
        });
    } else if (event.target.value === 'ปฎิเสธการจอง') {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการที่จะยืนยันรายการนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ปฎิเสธการจอง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = herf + id + '/' + select.value;
            } else {
                select.value = status_now;
            }
        });
    }

}

function checkStatus() {
    var select = document.querySelectorAll('.form-select');
    var status = select.value;
    if (status === 'ยืนยันการจอง') {
        select.classList.remove('text-danger', 'text-warning');
        select.classList.add('text-success');
    } else if (status === 'ปฎิเสธการจอง') {
        select.classList.remove('text-success', 'text-warning');
        select.classList.add('text-danger');
    } else if (status === 'ยกเลิกการจอง') {
        select.classList.remove('text-success', 'text-danger');
        select.classList.add('text-warning');
    }
}

checkStatus()


// เลือกทุก element ที่มี ID เป็น "countDown"
var countDownElements = document.querySelectorAll("#countDown");

// วนลูปผ่านทุกองค์ประกอบที่เลือกไว้
countDownElements.forEach(function (element) {
    // เพิ่มเหตุการณ์ด้วย addEventListener
    element.addEventListener("click", function () {
            var status_wt = element.dataset.status_wt;
            if(status_wt === 'มีการจองแล้ว'){
                // ทำสิ่งที่ต้องการเมื่อคลิกที่องค์ประกอบ
            var timeLate = element.dataset.timelate;
            var timeStart = element.dataset.timestart;

            // แปลงเวลาจากรูปแบบชั่วโมงเป็นนาทีและวินาที
            var hoursToSeconds = parseInt(timeStart.split(":")[0]) * 3600; // 1 ชั่วโมง = 3600 วินาที
            var minutesToSeconds = parseInt(timeStart.split(":")[1]) * 60; // 1 นาที = 60 วินาที
            var timeStartInSeconds = hoursToSeconds + minutesToSeconds;

            var hoursToSecondsLate = parseInt(timeLate.split(":")[0]) * 3600; // 1 ชั่วโมง = 3600 วินาที
            var minutesToSecondsLate = parseInt(timeLate.split(":")[1]) * 60; // 1 นาที = 60 วินาที
            var timeLateInSeconds = hoursToSecondsLate + minutesToSecondsLate;

            // บวกเวลากัน
            var totalSeconds = timeStartInSeconds + timeLateInSeconds;

            // แปลงเวลาทั้งหมดกลับเป็นรูปแบบเดิม
            var totalHours = Math.floor(totalSeconds / 3600);
            var remainingSeconds = totalSeconds % 3600;
            var totalMinutes = Math.floor(remainingSeconds / 60);

            // กำหนดให้รูปแบบของเวลามีทั้งหมด 2 ตัวเลข (เช่น 09:05 แทน 9:5)
            var formattedTotalHours = totalHours < 10 ? "0" + totalHours : totalHours;
            var formattedTotalMinutes = totalMinutes < 10 ? "0" + totalMinutes : totalMinutes;

            var totalTimeFormatted = formattedTotalHours + ":" + formattedTotalMinutes;

            var select_status = document.getElementById('select_status' + element.dataset.id);
            var status_success = select_status.dataset.status;
            // นับเวลาถอยหลัง
            var interval = setInterval(function () {
                var now = new Date();
                var currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();

                if (currentTime >= totalSeconds || status_success === 'ยกเลิกการจอง' || status_success === 'ยืนยันการจอง' || status_success === 'ปฎิเสธการจอง') {
                    clearInterval(interval); // หยุดการนับเวลาเมื่อเวลาปัจจุบันมากกว่าหรือเท่ากับเวลาที่กำหนด
                    if(status_success === 'ยกเลิกการจอง' || status_success === 'ยืนยันการจอง' || status_success === 'ปฎิเสธการจอง'){
                        select_status.disabled = true;
                        element.textContent = "หมดสิทธิ์เปลี่ยนแปลง";
                    }else{
                        var host = 'http://127.0.0.1:8000/';
                        var herf = host + 'Update_status_admin/';
                        var id = element.dataset.id;
                        window.location.href = herf + id + '/' + 'ปฎิเสธการจอง';
                    }  
                } else {
                    // คำนวณเวลาที่เหลือ
                    var remainingTime = totalSeconds - currentTime;
                    var remainingHours = Math.floor(remainingTime / 3600);
                    var remainingMinutes = Math.floor((remainingTime % 3600) / 60);
                    var remainingSeconds = remainingTime % 60;
                    select_status.disabled = false;
                    if (remainingHours === 0) {
                        element.textContent = "เวลที่เหลือ " + remainingMinutes + " : " + remainingSeconds + " นาที";
                    } else {
                        element.textContent = "เวลที่เหลือ " + remainingHours + " : " + remainingMinutes + " : " + remainingSeconds + " ชั่วโมง";
                    }

                }
            }, 1000);
        }else {
            var select_status = document.getElementById('select_status' + element.dataset.id);
            var status_success = select_status.dataset.status;
            // console.log(status_success)
            if(status_success === 'ยกเลิกการจอง' || status_success === 'ยืนยันการจอง' || status_success === 'ปฎิเสธการจอง'){
                select_status.disabled = true;
                element.textContent = "หมดสิทธิ์เปลี่ยนแปลง";
            }else{
                var host = 'http://127.0.0.1:8000/';
                var herf = host + 'Update_status_admin/';
                var id = element.dataset.id;
                window.location.href = herf + id + '/' + 'ยืนยันการจอง';
            }  
        }
    });

        element.click();  
});
