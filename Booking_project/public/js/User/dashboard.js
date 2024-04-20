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

    // ถ้าเวลาปัจจุบันมากกว่าหรือเท่ากับเวลาที่กำหนดให้รีเฟรช
    if (currentTime >= targetTimeTH) {
        location.reload(); // รีเฟรชหน้าเว็บ
    }
}, 60000); // ตรวจสอบทุกๆ 1 นาที (60000 มิลลิวินาที)

setInterval(currentTime, 1000);

function currentTime() {
    // กำหนดเวลาที่ต้องการให้แสดง div หลังเวลาปัจจุบันถึงเวลา 8:00 และซ่อน div เมื่อเวลาเกิน 16:30
    var currentTime = new Date();
    var targetTime = new Date(currentTime);
    targetTime.setHours(8, 0, 0); // เวลา 8:00 นาฬิกา
    var endOfDay = new Date(currentTime);
    endOfDay.setHours(16, 30, 0); // เวลา 16:30 นาฬิกา

    if (currentTime >= targetTime && currentTime <= endOfDay) {
        document.getElementById("hideDiv").classList.remove('d-none');
        document.getElementById("showDiv").classList.add('d-none');
    } else if (currentTime >= endOfDay) {
        document.getElementById("hideDiv").classList.add('d-none');
        document.getElementById("showDiv").classList.remove('d-none');
        var refreshTimeTH = currentTime.toLocaleTimeString('en-US', {
            timeZone: 'Asia/Bangkok'
        });
        document.getElementById("currentTime").innerText = "เวลาปัจจุบัน: " + refreshTimeTH;

    }
}
