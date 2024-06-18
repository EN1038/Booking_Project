// กำหนดเวลาในโซนเวลาของไทย (GMT+7)
var refreshTimeTH = new Date().toLocaleString('en-US', {
    timeZone: 'Asia/Bangkok'
});
var targetTimeTH = new Date(refreshTimeTH);
targetTimeTH.setHours(18); // กำหนดเวลาที่ต้องการให้รีเฟรช (เช่น 18:00 เป็นต้น)

// ตรวจสอบเวลาทุกๆ หนึ่งนาที
setInterval(function () {
    // รับเวลาปัจจุบัน
    var currentTime = new Date();
    var time = document.getElementById('currentTime');
    time.textContent = currentTime;
    // ถ้าเวลาปัจจุบันมากกว่าหรือเท่ากับเวลาที่กำหนดให้รีเฟรช
    if (currentTime >= targetTimeTH) {
        location.reload(); // รีเฟรชหน้าเว็บ
    }
}, 60000); // ตรวจสอบทุกๆ 1 นาที (60000 มิลลิวินาที)

setInterval(currentTime, 1000);

function currentTime() {
    // รับเวลาปัจจุบันในโซนเวลาไทย
    var currentTime = new Date().toLocaleString('en-US', { timeZone: 'Asia/Bangkok' });

    // แปลงเวลาปัจจุบันให้อยู่ในรูปแบบของวัตถุ Date
    var currentTimeObj = new Date(currentTime);

    // กำหนดเวลาเป้าหมาย 8:00 และ 16:30 ในโซนเวลาไทย
    var targetTime = new Date(currentTimeObj);
    targetTime.setHours(8, 0, 0);

    var endOfDay = new Date(currentTimeObj);
    endOfDay.setHours(16, 30, 0);

    // ตรวจสอบว่า currentTime อยู่ระหว่างเวลาเริ่มต้นและสิ้นสุดหรือไม่
    if (currentTimeObj >= targetTime && currentTimeObj <= endOfDay) {
        // ถ้าอยู่ระหว่างเวลาเริ่มต้นและสิ้นสุด ให้แสดง hideDiv
        document.getElementById("hideDiv").classList.remove('d-none');
        document.getElementById("showDiv").classList.add('d-none');
    } else {
        // ถ้าเกินเวลาสิ้นสุดหรือยังไม่ถึงเวลาเริ่มต้น ให้แสดง showDiv
        document.getElementById("hideDiv").classList.add('d-none');
        document.getElementById("showDiv").classList.remove('d-none');
    }
}



