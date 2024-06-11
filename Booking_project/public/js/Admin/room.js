function showDurationTime() {
    const typeRoomsInput = document.getElementById('select_typeRoom');
    const timeDurationDisplay = document.getElementById('time_duration');
    const timeDuration = typeRoomsInput.dataset.timeduration;
    const [durationHour, durationMinute] = timeDuration.split(':').map(Number);
    const time = formatTime(durationHour, durationMinute)
    timeDurationDisplay.value = time;
    createOptionTime()

}

function createOptionTime() {
    const fild_timeDuration = document.getElementById('fild_timeDuration');
    const timeDuration = document.getElementById('time_duration').value; // รับค่า timeDuration จาก input
    const label_time_work = document.getElementById('time_working');

    label_time_work.classList.remove('d-none');
    // เวลาเริ่มต้น
    const startTime = '08:30';
    // เวลาสิ้นสุด
    const endTime = '16:30';

    // แปลง startTime เป็นชั่วโมงและนาที
    const [startHour, startMinute] = startTime.split(':').map(Number);

    // แปลง endTime เป็นชั่วโมงและนาที
    const [endHour, endMinute] = endTime.split(':').map(Number);

    // แปลง timeDuration เป็นชั่วโมงและนาที
    const [durationHour, durationMinute] = timeDuration.split(':').map(Number);

    var count = 0;
    // คำนวณเวลาในช่วงที่กำหนด
    let currentHour = startHour;
    let currentMinute = startMinute;
    fild_timeDuration.innerHTML = '';
    while (true) {
        const currentTime = formatTime(currentHour, currentMinute); // แปลงเวลาเป็นรูปแบบ HH:mm

        if (currentTime > endTime) { // เมื่อ currentTime เกินเวลาสิ้นสุด
            break;
        }
        const div = document.createElement('div');
        div.classList.add('col-4');
        div.id = 'div' + count;
        fild_timeDuration.appendChild(div);

        const sr_div = document.getElementById('div' + count);
        const input = document.createElement('input');
        input.value = currentTime;
        input.classList.add('form-control', 'text-center', 'my-2');
        input.readOnly = true;
        input.id = 'time_start' + count;
        input.name = 'time_start_working[]';
        sr_div.appendChild(input);

        if (count != 0) {
            var time_now = document.getElementById('time_start' + count);
            var div_after = document.getElementById('div' + (count - 1));
            var time = time_now.value;

            // แยกชั่วโมงและนาทีออกจากกัน
            var parts = time.split(':');
            var hours = parseInt(parts[0], 10);
            var minutes = parseInt(parts[1], 10);

            // แปลงเวลาเป็นวินาที
            var timeInSeconds = hours * 3600 + minutes * 60;

            // ลบหนึ่งนาที
            timeInSeconds -= 60;

            // แปลงเวลากลับเป็นชั่วโมงและนาที
            var newHours = Math.floor(timeInSeconds / 3600);
            var newMinutes = Math.floor((timeInSeconds % 3600) / 60);

            // รวมเวลาใหม่
            var newTime = (newHours < 10 ? '0' : '') + newHours + ':' + (newMinutes < 10 ? '0' : '') + newMinutes;


            const inputs = document.createElement('input');
            inputs.value = newTime;
            inputs.classList.add('form-control', 'text-center', 'my-2');
            inputs.hidden = true;
            inputs.name = 'time_end_working[]';
            div_after.appendChild(inputs);


        }


        // เพิ่มเวลาโดยใช้ timeDuration
        currentHour += durationHour;
        currentMinute += durationMinute;
        if (currentMinute >= 60) {
            currentHour += 1;
            currentMinute -= 60;
        }

        // ตรวจสอบว่าเกินเวลาสิ้นสุดหรือไม่
        if (currentHour > endHour || (currentHour === endHour && currentMinute > endMinute)) {
            const inputs = document.createElement('input');
            inputs.value = '16:30';
            inputs.classList.add('form-control', 'text-center', 'my-2');
            inputs.hidden = true;
            inputs.name = 'time_end_working[]';
            sr_div.appendChild(inputs);
        }

        count += 1;
    }
}

function formatTime(hour, minute) {
    return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
}

function validationName() {
    const nameRooms = document.getElementById('nameRooms').value;
    const errorNameRoom = document.getElementById('errorNameRoom');

    if (nameRooms.length > 20) {
        errorNameRoom.classList.remove('d-none');
        errorNameRoom.textContent = 'ข้อความยาวเกินไป';
        return;
    }

    if (nameRooms === "") {
        errorNameRoom.classList.remove('d-none');
        errorNameRoom.textContent = 'กรุณากรอกชื่อ';
        return;
    }

    fetch('/api/Rooms')
        .then(response => {
            // ตรวจสอบสถานะการเชื่อมต่อ
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // แปลงข้อมูลเป็น JSON
            return response.json();
        })
        .then(data => {
            // สร้างอาเรย์เพื่อเก็บ name_room โดยไม่ซ้ำกัน
            const uniqueNames = [];

            data.forEach(item => {
                // ตรวจสอบว่า name_room ไม่ซ้ำกับที่มีอยู่ในอาเรย์ uniqueNames แล้วจึงเพิ่มเข้าไป
                if (!uniqueNames.includes(item.name_room)) {
                    uniqueNames.push(item.name_room);
                }
            });
            // ตรวจสอบว่า nameRoom ซ้ำกับค่าในอาเรย์ uniqueNames หรือไม่
            if (uniqueNames.includes(nameRooms)) {
                const nameRoom = document.getElementById('nameRooms').value;
                nameRoom.value = '';
                errorNameRoom.classList.remove('d-none');
                errorNameRoom.textContent = 'มีชื่อนี้อยู่ในระบบแล้ว โปรดใช้ชื่ออื่น'
                return;
            }
        })
        .catch(error => {
            // ดำเนินการเมื่อเกิดข้อผิดพลาด
            console.error('There was a problem with your fetch operation:', error);
        });

    errorNameRoom.classList.add('d-none');
    showDurationTime();
}

function validateSelectStatus() {
    const selectStatus = document.getElementById('selectStatus');
    const errorSelectStatus = document.getElementById('errorSelectStatus');

    errorSelectStatus.classList.remove('d-none');
    errorSelectStatus.textContent = 'โปรดเลือกสถานะของห้อง';

    if (selectStatus.value === "On" || selectStatus.value === 'Off') {
        errorSelectStatus.classList.add('d-none');
    }

}

function confirmDelete(event) {
    event.preventDefault(); // ยกเลิกการทำงานของลิงก์

    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: "คุณต้องการที่จะลบรายการนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ฉันต้องการลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = event.target.href;
        }
    });
}

function validationImg() {
    var fileInput = document.getElementById('formFile');
    var errorLabel = document.getElementById("errorImgRoom");
    const button = document.getElementById('btn-create');
    // ตรวจสอบว่ามีการเลือกไฟล์หรือไม่
    if (fileInput.files.length === 0) {
        errorLabel.textContent = "โปรดเลือกรูปภาพ";
        button.disabled = true;
    } else {
        // ตรวจสอบขนาดของไฟล์
        var maxSize = 2 * 1024 * 1024; // ขนาดสูงสุดของไฟล์ภาพ (2MB)
        if (fileInput.files[0].size > maxSize) {
            errorLabel.textContent = "ขนาดของไฟล์ภาพต้องไม่เกิน 2MB";
            button.disabled = true;
        } else {
            // ตรวจสอบชนิดของไฟล์ภาพ
            var allowedExtensions = ["jpg", "jpeg", "png", "gif"];
            var extension = fileInput.files[0].name.split(".").pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                errorLabel.textContent = "รูปภาพไม่ได้รับอนุญาตให้ใช้";
                button.disabled = true;
            } else {
                // ล้างข้อความผิดพลาดหากไม่มีปัญหา
                errorLabel.textContent = "";
            }
        }
    }

}

function create() {
    const button = document.getElementById('btn-create');
    const inputImg = document.getElementById('formFile');
    const inputName = document.getElementById('nameRooms');
    const inputStatus = document.getElementById('selectStatus');

    function toggleButtonState() {
        if (inputImg.value !== '' && inputName.value !== '' && inputStatus.value !== '') {
            button.removeAttribute('disabled');
        } else {
            button.setAttribute('disabled', 'disabled');
        }
    }

    // เรียกใช้ฟังก์ชัน toggleButtonState เมื่อมีการเปลี่ยนแปลงใน input fields
    inputImg.addEventListener('change', toggleButtonState);
    inputName.addEventListener('input', toggleButtonState);
    inputStatus.addEventListener('change', toggleButtonState);
}

function validationEditImg() {
    var fileInput = event.target;
    var id = event.target.dataset.id;
    var errorLabel = document.getElementById("errorImgRoom" + id);
    const button = document.getElementById('editName' + id);
    // ตรวจสอบว่ามีการเลือกไฟล์หรือไม่
    if (fileInput.files.length === 0) {
        errorLabel.textContent = "โปรดเลือกรูปภาพ";
        button.disabled = true;
    } else {
        // ตรวจสอบขนาดของไฟล์
        var maxSize = 2 * 1024 * 1024; // ขนาดสูงสุดของไฟล์ภาพ (2MB)
        if (fileInput.files[0].size > maxSize) {
            errorLabel.textContent = "ขนาดของไฟล์ภาพต้องไม่เกิน 2MB";
            button.disabled = true;
        } else {
            // ตรวจสอบชนิดของไฟล์ภาพ
            var allowedExtensions = ["jpg", "jpeg", "png", "gif"];
            var extension = fileInput.files[0].name.split(".").pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                errorLabel.textContent = "รูปภาพไม่ได้รับอนุญาตให้ใช้";
                button.disabled = true;
            } else {
                // ล้างข้อความผิดพลาดหากไม่มีปัญหา
                errorLabel.textContent = "";
            }
        }
    }
}

function validationNameEdit(event) {
    const nameRooms = event.target.value;
    const id = event.target.dataset.id;
    const errorNameRoom = document.getElementById('errorNameRoom' + id);
    const button = document.getElementById('editName' + id);

    if (nameRooms.length > 20) {
        errorNameRoom.classList.remove('d-none');
        errorNameRoom.textContent = 'ข้อความยาวเกินไป';
        button.disabled = true;
        return;
    }

    if (nameRooms === "") {
        errorNameRoom.classList.remove('d-none');
        errorNameRoom.textContent = 'กรุณากรอกชื่อ';
        button.disabled = true;
        return;
    }

    fetch('/api/Rooms')
        .then(response => {
            // ตรวจสอบสถานะการเชื่อมต่อ
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // แปลงข้อมูลเป็น JSON
            return response.json();
        })
        .then(data => {
            // สร้างอาเรย์เพื่อเก็บ name_room โดยไม่ซ้ำกัน
            const uniqueNames = [];

            data.forEach(item => {
                // ตรวจสอบว่า name_room ไม่ซ้ำกับที่มีอยู่ในอาเรย์ uniqueNames แล้วจึงเพิ่มเข้าไป
                if (!uniqueNames.includes(item.name_room)) {
                    uniqueNames.push(item.name_room);
                }
            });
            // ตรวจสอบว่า nameRoom ซ้ำกับค่าในอาเรย์ uniqueNames หรือไม่
            if (uniqueNames.includes(nameRooms)) {
                const nameEditRoom = event.target;
                nameEditRoom.value = "";
                errorNameRoom.classList.remove('d-none');
                errorNameRoom.textContent = 'มีชื่อนี้อยู่ในระบบแล้ว โปรดใช้ชื่ออื่น'
                button.disabled = true;
                return;
            }
        })
        .catch(error => {
            // ดำเนินการเมื่อเกิดข้อผิดพลาด
            console.error('There was a problem with your fetch operation:', error);
        });

    errorNameRoom.classList.add('d-none');
    button.disabled = false;
}


validationName()
validationImg()
validateSelectStatus()
create()
