function showDurationTime(){
    const typeRoomsSelect = document.getElementById('select_typeRoom');
    const timeDurationDisplay = document.getElementById('time_duration');
    const selectedOption = typeRoomsSelect.options[typeRoomsSelect.selectedIndex];
    const timeDuration = selectedOption.dataset.timeduration;
    const [durationHour, durationMinute] = timeDuration.split(':').map(Number);
    const time = formatTime(durationHour, durationMinute)
    timeDurationDisplay.value = time;
    createOptionTime()
    validateSelectType()
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
        div.id = 'div'+count;
        fild_timeDuration.appendChild(div);

        const sr_div = document.getElementById('div'+count);
        const input = document.createElement('input');
        input.value = currentTime;
        input.classList.add('form-control','text-center','my-2');
        input.readOnly = true;
        input.name = 'time_working[]';
        sr_div.appendChild(input);

        count+=1;
        // เพิ่มเวลาโดยใช้ timeDuration
        currentHour += durationHour;
        currentMinute += durationMinute;
        if (currentMinute >= 60) {
            currentHour += 1;
            currentMinute -= 60;
        }
        
        // ตรวจสอบว่าเกินเวลาสิ้นสุดหรือไม่
        if (currentHour > endHour || (currentHour === endHour && currentMinute > endMinute)) {
            break;
        }

      
    }
}

function formatTime(hour, minute) {
    return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
}

function validationName(){
    const nameRooms = document.getElementById('nameRooms').value;
    const errorNameRoom = document.getElementById('errorNameRoom');

    if (nameRooms.length > 20) {
        errorNameRoom.classList.remove('d-none');
        errorNameRoom.textContent = 'ข้อความยาวเกินไป';
        return;
    }

    if(nameRooms === ""){
        errorNameRoom.classList.remove('d-none');
        errorNameRoom.textContent = 'กรุณากรอกชื่อ'
        return;
    }
    errorNameRoom.classList.add('d-none');

    api_room(nameRooms);
}

function api_room(nameRoom){
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
        if (uniqueNames.includes(nameRoom)) {
            const nameRooms = document.getElementById('nameRooms');
            const errorNameRoom = document.getElementById('errorNameRoom');

            nameRooms.value = "";
            errorNameRoom.classList.remove('d-none');
            errorNameRoom.textContent ='มีชื่อนี้อยู่ในระบบแล้ว โปรดใช้ชื่ออื่น'
        }
    })
    .catch(error => {
        // ดำเนินการเมื่อเกิดข้อผิดพลาด
        console.error('There was a problem with your fetch operation:', error);
    });
}
function validateSelectType(){
    const time_duration = document.getElementById('time_duration');
    const errorSelectType = document.getElementById('errorSelectType');
    
    if(time_duration.value === ""){
        errorSelectType.classList.remove('d-none');
        errorSelectType.textContent = 'โปรดเลือกประเภทของห้อง';
    }else{
        errorSelectType.classList.add('d-none');
    }
    
}

function validateSelectStatus(){
    const selectStatus = document.getElementById('selectStatus');
    const errorSelectStatus = document.getElementById('errorSelectStatus');
    
    errorSelectStatus.classList.remove('d-none');
    errorSelectStatus.textContent = 'โปรดเลือกสถานะของห้อง';

    if(selectStatus.value === "On" || selectStatus.value === 'Off'){
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

// const id = event.target.dataset.id;
//     const editTypeRoomsSelect = document.getElementById('editSelect_typeRoom'+id);
//     console.log(id)
//     const edits = document.getElementById('editduration'+id);
//     console.log(edits)
//     const selectedOption = editTypeRoomsSelect.options[editTypeRoomsSelect.selectedIndex];
//     const timeDuration = selectedOption.dataset.timeduration;
//     const [durationHour, durationMinute] = timeDuration.split(':').map(Number);
//     const time = formatTime(durationHour, durationMinute)
//     console.log(time)
//     edits.value = time;
//     // createOptionTime()
//     // validateSelectType()


api_room()
validationName()
validateSelectType()
validateSelectStatus()
