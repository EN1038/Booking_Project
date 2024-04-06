function changStatus() {
    var select = event.target;
    var status_now = event.target.dataset.status;
    var id = event.target.dataset.id;
    var herf = 'http://127.0.0.1:8000/Update_status_user/';
    console.log(herf)
    if (event.target.value === 'ยกเลิกการจอง') {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการที่จะยกเลิกรายการนี้ใช่หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ยกเลิกการจอง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = herf + id + '/' + select.value;
            } else {
                select.value = status_now;
            }
        });
    } else {

    }

}

// เลือกทุก element ที่มี ID เป็น "countDown"
var countDownElements = document.querySelectorAll("#countDown");

// วนลูปผ่านทุกองค์ประกอบที่เลือกไว้
countDownElements.forEach(function (element) {
    // เพิ่มเหตุการณ์ด้วย addEventListener
    element.addEventListener("click", function () {
        // ทำสิ่งที่ต้องการเมื่อคลิกที่องค์ประกอบ
        var timeCancel = element.dataset.timecancel;
        var timeStart = element.dataset.timestart;

        // แปลงเวลาจากรูปแบบชั่วโมงเป็นนาทีและวินาที
        var hoursToSeconds = parseInt(timeStart.split(":")[0]) * 3600; // 1 ชั่วโมง = 3600 วินาที
        var minutesToSeconds = parseInt(timeStart.split(":")[1]) * 60; // 1 นาที = 60 วินาที
        var timeStartInSeconds = hoursToSeconds + minutesToSeconds;

        var hoursToSecondsCancel = parseInt(timeCancel.split(":")[0]) * 3600; // 1 ชั่วโมง = 3600 วินาที
        var minutesToSecondsCancel = parseInt(timeCancel.split(":")[1]) * 60; // 1 นาที = 60 วินาที
        var timeCancelInSeconds = hoursToSecondsCancel + minutesToSecondsCancel;

        // บวกเวลากัน
        var totalSeconds = timeStartInSeconds - timeCancelInSeconds;

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
                select_status.disabled = true;
                element.textContent = "หมดสิทในการยกเลิก";
            } else {
                // คำนวณเวลาที่เหลือ
                var remainingTime = totalSeconds - currentTime;
                var remainingHours = Math.floor(remainingTime / 3600);
                var remainingMinutes = Math.floor((remainingTime % 3600) / 60);
                var remainingSeconds = remainingTime % 60;
                select_status.disabled = false;
                if (remainingHours === 0) {
                    element.textContent = "เวลที่เหลือในการยกเลิก " + remainingMinutes + " : " + remainingSeconds + " นาที";
                } else {
                    element.textContent = "เวลที่เหลือในการยกเลิก " + remainingHours + " : " + remainingMinutes + " : " + remainingSeconds + " ชั่วโมง";
                }

            }
        }, 1000);
    });

    element.click();
});
