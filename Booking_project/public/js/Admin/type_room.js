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


function combineTime() {
    var hour = document.getElementById("hourInput").value;
    var minute = document.getElementById("minuteInput").value;
    const trueTime = document.getElementById('trueTime');
    const errorTime = document.getElementById('ErrorTime');

    if (hour.includes(".") || minute.includes(".")) {
        errorTime.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTime.classList.remove('d-none');
        return;
    }

    if (/[^0-9]/g.test(hour) || /[^0-9]/g.test(minute)) {
        errorTime.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTime.classList.remove('d-none');
        return;
    }

    if (hour === "" || minute === "") {
        errorTime.textContent = 'กรุณากรอกเวลาให้ครบทุกช่อง'
        errorTime.classList.remove('d-none');
        return;
    }

    // ตรวจสอบความถูกต้องของเวลาที่รับมา
    if (isNaN(hour) || isNaN(minute) || parseInt(hour) < 0 || parseInt(hour) > 23 || parseInt(minute) < 0 || parseInt(minute) > 59) {
        errorTime.textContent = 'รูปแบบเวลาไม่ถูกต้อง'
        errorTime.classList.remove('d-none');
        return;
    }

    // เติม 0 หน้าหลักเดียวในเลขชั่วโมงหรือนาที
    hour = hour.padStart(2, '0');
    minute = minute.padStart(2, '0');

    // สร้างเวลาแบบเต็ม
    var fullTime = hour + ":" + minute;
    // console.log("เวลาที่รวมเข้าด้วยกัน: " + fullTime);
    errorTime.classList.add('d-none')
    trueTime.value = fullTime;
}

function convertMinutesToTime() {
    var errorTimeCancel = document.getElementById('ErrorTimeCancel');
    var minute = document.getElementById('timeBeforCancel')
    var input = document.getElementById('trueTimeCancel');
    var hours = Math.floor(minute.value / 60);
    var minutes = minute.value % 60;

    if (minute.value.includes(".")) {
        errorTimeCancel.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    if (/[^0-9]/g.test(minute.value)) {
        errorTimeCancel.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    if (minute.value === "") {
        errorTimeCancel.textContent = 'กรุณากรอกเวลาให้ครบทุกช่อง'
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    if (parseInt(minute.value) < 0 || parseInt(minute.value) > 59) {
        errorTimeCancel.textContent = 'รูปแบบเวลาไม่ถูกต้อง'
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    // แปลงชั่วโมงและนาทีให้อยู่ในรูปแบบที่ถูกต้อง (ในกรณีที่ต้องการให้แสดงเลขหน่วยนับเป็นเลขคู่ เช่น 00, 01, 02, ... 59)
    var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
    errorTimeCancel.classList.add('d-none')
    input.value = formattedTime;
}

function convertMinutesToTimeLate() {
    var errorTimeLate = document.getElementById('ErrorTimeLate');
    var minute = document.getElementById('timeBeforLate')
    var input = document.getElementById('trueTimeLate');
    var hours = Math.floor(minute.value / 60);
    var minutes = minute.value % 60;

    if (minute.value.includes(".")) {
        errorTimeLate.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeLate.classList.remove('d-none');
        return;
    }

    if (/[^0-9]/g.test(minute.value)) {
        errorTimeLate.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeLate.classList.remove('d-none');
        return;
    }

    if (minute.value === "") {
        errorTimeLate.textContent = 'กรุณากรอกเวลาให้ครบทุกช่อง'
        errorTimeLate.classList.remove('d-none');
        return;
    }

    if (parseInt(minute.value) < 0 || parseInt(minute.value) > 59) {
        errorTimeLate.textContent = 'รูปแบบเวลาไม่ถูกต้อง'
        errorTimeLate.classList.remove('d-none');
        return;
    }

    // แปลงชั่วโมงและนาทีให้อยู่ในรูปแบบที่ถูกต้อง (ในกรณีที่ต้องการให้แสดงเลขหน่วยนับเป็นเลขคู่ เช่น 00, 01, 02, ... 59)
    var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
    errorTimeLate.classList.add('d-none')
    input.value = formattedTime;
}

function convertEditMinutesToTime() {
    var id = event.target.dataset.id;
    var errorTimeCancel = document.getElementById('ErrorEditTimeCancel' + id);
    var minute = event.target.value;
    var input = document.getElementById('trueEditTimeCancel' + id);
    var hours = Math.floor(minute / 60);
    var minutes = minute % 60;

    if (minute.includes(".")) {
        errorTimeCancel.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    if (/[^0-9]/g.test(minute)) {
        errorTimeCancel.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    if (minute === "") {
        errorTimeCancel.textContent = 'กรุณากรอกเวลาให้ครบทุกช่อง'
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    if (parseInt(minute) < 0 || parseInt(minute.value) > 59) {
        errorTimeCancel.textContent = 'รูปแบบเวลาไม่ถูกต้อง'
        errorTimeCancel.classList.remove('d-none');
        return;
    }

    // แปลงชั่วโมงและนาทีให้อยู่ในรูปแบบที่ถูกต้อง (ในกรณีที่ต้องการให้แสดงเลขหน่วยนับเป็นเลขคู่ เช่น 00, 01, 02, ... 59)
    var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);

    errorTimeCancel.classList.add('d-none')
    input.value = formattedTime;
    confirmEdit(id)
}
function convertEditMinutesToTimeLate() {
    var id = event.target.dataset.id;
    var errorTimeLate = document.getElementById('ErrorEditTimeLate' + id);
    var minute = event.target.value;
    var input = document.getElementById('trueEditTimeLate' + id);
    var hours = Math.floor(minute / 60);
    var minutes = minute % 60;

    if (minute.includes(".")) {
        errorTimeLate.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeLate.classList.remove('d-none');
        return;
    }

    if (/[^0-9]/g.test(minute)) {
        errorTimeLate.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        errorTimeLate.classList.remove('d-none');
        return;
    }

    if (minute === "") {
        errorTimeLate.textContent = 'กรุณากรอกเวลาให้ครบทุกช่อง'
        errorTimeLate.classList.remove('d-none');
        return;
    }

    if (parseInt(minute) < 0 || parseInt(minute.value) > 59) {
        errorTimeLate.textContent = 'รูปแบบเวลาไม่ถูกต้อง'
        errorTimeLate.classList.remove('d-none');
        return;
    }

    // แปลงชั่วโมงและนาทีให้อยู่ในรูปแบบที่ถูกต้อง (ในกรณีที่ต้องการให้แสดงเลขหน่วยนับเป็นเลขคู่ เช่น 00, 01, 02, ... 59)
    var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);

    errorTimeLate.classList.add('d-none')
    input.value = formattedTime;
    confirmEdit(id)
}

function validate_NameTypeRoom() {
    const nameTypeRooms = document.getElementById('nameTypeRooms').value;
    const errornameTypeRooms = document.getElementById('errornameTypeRooms');

    if (nameTypeRooms.length > 20) {
        errornameTypeRooms.classList.remove('d-none');
        errornameTypeRooms.textContent = 'ข้อความยาวเกินไป';
        return;
    }

    if (nameTypeRooms === "") {

        errornameTypeRooms.classList.remove('d-none');
        errornameTypeRooms.textContent = 'กรุณากรอกชื่อ'
        return;
    }
    errornameTypeRooms.classList.add('d-none');
}

function validate_NumberUser() {
    const numberUser = document.getElementById('numberUser').value;
    const errorNumberUser = document.getElementById('errorNumberUser');

    console.log(numberUser);
    if (numberUser === "") {
        errorNumberUser.classList.remove('d-none');
        errorNumberUser.textContent = 'กรุณากรอกจำนวนคน';
        return;
    }

    if (/\./.test(numberUser)) {
        errorNumberUser.classList.remove('d-none');
        errorNumberUser.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        return;
    }

    if (/[^0-9]/g.test(numberUser)) {
        errorNumberUser.classList.remove('d-none');
        errorNumberUser.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        return;
    }

    errorNumberUser.classList.add('d-none');

}

function conFirmCreateTypeRoom() {
    const buttonConfirm = event.target
    const buttonCreate = document.getElementById('buttonCreate');
    const bottomClose = document.getElementById('bottomClose');
    const buttonUndu = document.getElementById('buttonUndu');
    const hour = document.getElementById("hourInput");
    const minute = document.getElementById("minuteInput");
    const numberUser = document.getElementById('numberUser');
    const nameTypeRooms = document.getElementById('nameTypeRooms');
    const errorNumberUser = document.getElementById('errorNumberUser');
    const errornameTypeRooms = document.getElementById('errornameTypeRooms');
    const errorTime = document.getElementById('ErrorTime');
    var minutea = document.getElementById('timeBeforCancel')
    var errorTimeCancel = document.getElementById('ErrorTimeCancel');
    var errorTimeLate = document.getElementById('ErrorTimeLate');
    buttonConfirm.innerHTML = '<i class="fa-solid fa-spinner fa-spin-pulse"></i> รอสักครู่';
    buttonUndu.innerHTML = 'กรอกค่าใหม่';
    setTimeout(function () {
        buttonConfirm.classList.add('d-none');
        bottomClose.classList.add('d-none');
        buttonCreate.classList.remove('d-none');
        buttonUndu.classList.remove('d-none');
        hour.readOnly = true;
        minute.readOnly = true;
        numberUser.readOnly = true;
        nameTypeRooms.readOnly = true;
        minutea.readOnly = true;
        combineTime()
        validate_NumberUser()
        validate_NameTypeRoom()
        convertMinutesToTime()
        convertMinutesToTimeLate()
        if (!errorNumberUser.classList.contains('d-none') && !errorTime.classList.contains('d-none') && !errornameTypeRooms.classList.contains('d-none') && !errorTimeCancel.classList.contains('d-none')&& !errorTimeLate.classList.contains('d-none')) {
            buttonCreate.disabled = true;
        } else {
            buttonCreate.disabled = false;
        }

    }, 2000);


}

function UndoValue() {
    const buttonUndu = document.getElementById('buttonUndu');
    const buttonCreate = document.getElementById('buttonCreate');
    const bottomClose = document.getElementById('bottomClose');
    const buttonConfirm = document.getElementById('buttonConfirm');
    const hour = document.getElementById("hourInput");
    const minute = document.getElementById("minuteInput");
    const numberUser = document.getElementById('numberUser');
    const nameTypeRooms = document.getElementById('nameTypeRooms');
    var minutea = document.getElementById('timeBeforCancel')
    buttonConfirm.innerHTML = 'ตรวจสอบ';
    buttonUndu.innerHTML = '<i class="fa-solid fa-spinner fa-spin-pulse"></i> รอสักครู่'
    setTimeout(function () {
        buttonConfirm.classList.remove('d-none');
        bottomClose.classList.remove('d-none');
        buttonCreate.classList.add('d-none');
        buttonUndu.classList.add('d-none');
        hour.readOnly = false;
        minute.readOnly = false;
        numberUser.readOnly = false;
        nameTypeRooms.readOnly = false;
        minutea.readOnly = false;
    }, 1000);
}

function combineTimeEdit() {
    const id = event.target.dataset.id;
    var hour = document.getElementById("editHourInput" + id).value;
    var minute = document.getElementById("editMinuteInput" + id).value;
    const editTrueTime = document.getElementById('editTrueTime' + id);
    const editErrorTime = document.getElementById('editErrorTime' + id);

    if (hour.includes(".") || minute.includes(".")) {
        editErrorTime.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        editErrorTime.classList.remove('d-none');
        return;
    }

    if (/[^0-9]/g.test(hour) || /[^0-9]/g.test(minute)) {
        editErrorTime.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        editErrorTime.classList.remove('d-none');
        return;
    }

    if (hour === "" || minute === "") {
        editErrorTime.textContent = 'กรุณากรอกเวลาให้ครบทุกช่อง'
        editErrorTime.classList.remove('d-none');
        return;
    }

    // ตรวจสอบความถูกต้องของเวลาที่รับมา
    if (isNaN(hour) || isNaN(minute) || parseInt(hour) < 0 || parseInt(hour) > 23 || parseInt(minute) < 0 || parseInt(minute) > 59) {
        editErrorTime.textContent = 'รูปแบบเวลาไม่ถูกต้อง'
        editErrorTime.classList.remove('d-none');
        return;
    }

    // เติม 0 หน้าหลักเดียวในเลขชั่วโมงหรือนาที
    hour = hour.padStart(2, '0');
    minute = minute.padStart(2, '0');

    // สร้างเวลาแบบเต็ม
    var fullTime = hour + ":" + minute;
    // console.log("เวลาที่รวมเข้าด้วยกัน: " + fullTime);
    editErrorTime.classList.add('d-none')
    editTrueTime.value = fullTime;
    confirmEdit(id)
}

function validate_EditNameTypeRoom() {
    const id = event.target.dataset.id;
    const editNameTypeRooms = document.getElementById('editNameTypeRooms' + id).value;
    const editErrornameTypeRooms = document.getElementById('editErrornameTypeRooms' + id);
    console.log(editNameTypeRooms)
    if (editNameTypeRooms.length > 20) {
        editErrornameTypeRooms.classList.remove('d-none');
        editErrornameTypeRooms.textContent = 'ข้อความยาวเกินไป';
        return;
    }

    if (editNameTypeRooms === "") {
        editErrornameTypeRooms.classList.remove('d-none');
        editErrornameTypeRooms.textContent = 'กรุณากรอกชื่อ'
        return;
    }
    editErrornameTypeRooms.classList.add('d-none');
    confirmEdit(id)
}

function validate_EditNumberUser() {
    const id = event.target.dataset.id;
    const editNumberUser = document.getElementById('editNumberUser' + id).value;
    const editErrorNumberUser = document.getElementById('editErrorNumberUser' + id);

    if (editNumberUser === "") {
        editErrorNumberUser.classList.remove('d-none');
        editErrorNumberUser.textContent = 'กรุณากรอกจำนวนคน';
        return;
    }

    if (/\./.test(editNumberUser)) {
        editErrorNumberUser.classList.remove('d-none');
        editErrorNumberUser.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        return;
    }

    if (/[^0-9]/g.test(editNumberUser)) {
        editErrorNumberUser.classList.remove('d-none');
        editErrorNumberUser.textContent = 'รูปแบบเวลาไม่ถูกต้อง';
        return;
    }

    editErrorNumberUser.classList.add('d-none');
    confirmEdit(id)
}

function confirmEdit(id) {
    const editErrorNumberUser = document.getElementById('editErrorNumberUser' + id);
    const editErrornameTypeRooms = document.getElementById('editErrornameTypeRooms' + id);
    const editErrorTime = document.getElementById('editErrorTime' + id);
    const editButtonCreate = document.getElementById('editButtonCreate' + id);
    const errorTimeCancel = document.getElementById('ErrorEditTimeCancel' + id);

    if (!editErrorNumberUser.classList.contains('d-none') && !editErrorTime.classList.contains('d-none') && !editErrornameTypeRooms.classList.contains('d-none') && !errorTimeCancel.classList.contains('d-none')) {
        editButtonCreate.disabled = true;
    } else {
        editButtonCreate.disabled = false;
    }
}
