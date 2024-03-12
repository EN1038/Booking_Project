
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

function validate_NameTypeRoom(){
    const nameTypeRooms = document.getElementById('nameTypeRooms').value;
    const errornameTypeRooms = document.getElementById('errornameTypeRooms');

    if (nameTypeRooms.length > 20) {
        errornameTypeRooms.classList.remove('d-none');
        errornameTypeRooms.textContent = 'ข้อความยาวเกินไป';
        return;
    }

    if(nameTypeRooms === ""){
        
        errornameTypeRooms.classList.remove('d-none');
        errornameTypeRooms.textContent = 'กรุณากรอกชื่อ'
        return;
    }
    errornameTypeRooms.classList.add('d-none');
}

function validate_NumberUser(){
    const numberUser = document.getElementById('numberUser').value;
    const errorNumberUser = document.getElementById('errorNumberUser');
    
    console.log(numberUser);
    if (numberUser=== "") {
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

function conFirmCreateTypeRoom(){
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
     buttonConfirm.innerHTML = '<i class="fa-solid fa-spinner fa-spin-pulse"></i> รอสักครู่';
     buttonUndu.innerHTML = 'กรอกค่าใหม่';
     setTimeout(function() {
        buttonConfirm.classList.add('d-none');
        bottomClose.classList.add('d-none');
        buttonCreate.classList.remove('d-none');
        buttonUndu.classList.remove('d-none');
        hour.readOnly = true;
        minute.readOnly = true;
        numberUser.readOnly = true;
        nameTypeRooms.readOnly = true;
        combineTime()
        validate_NumberUser()
        validate_NameTypeRoom()
        if (!errorNumberUser.classList.contains('d-none') && !errorTime.classList.contains('d-none') && !errornameTypeRooms.classList.contains('d-none')) {
            buttonCreate.disabled = true;
        }else{
            buttonCreate.disabled = false;
        }
        
     }, 2000);
    
     
}

function UndoValue(){
    const buttonUndu = document.getElementById('buttonUndu');
    const buttonCreate = document.getElementById('buttonCreate');
    const bottomClose = document.getElementById('bottomClose');
    const buttonConfirm = document.getElementById('buttonConfirm');
    const hour = document.getElementById("hourInput");
    const minute = document.getElementById("minuteInput");
    const numberUser = document.getElementById('numberUser');
    const nameTypeRooms = document.getElementById('nameTypeRooms');
    buttonConfirm.innerHTML = 'ตรวจสอบ';
    buttonUndu.innerHTML ='<i class="fa-solid fa-spinner fa-spin-pulse"></i> รอสักครู่'
    setTimeout(function() {
        buttonConfirm.classList.remove('d-none');
        bottomClose.classList.remove('d-none');
        buttonCreate.classList.add('d-none');
        buttonUndu.classList.add('d-none');
        hour.readOnly = false;
        minute.readOnly = false;
        numberUser.readOnly = false;
        nameTypeRooms.readOnly = false;
     }, 1000);
}

function combineTimeEdit() {
    const id = event.target.dataset.id;
    var hour = document.getElementById("editHourInput"+id).value;
    var minute = document.getElementById("editMinuteInput"+id).value;
    const editTrueTime = document.getElementById('editTrueTime'+id);
    const editErrorTime = document.getElementById('editErrorTime'+id);
    
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

function validate_EditNameTypeRoom(){
    const id = event.target.dataset.id;
    const editNameTypeRooms = document.getElementById('editNameTypeRooms'+id).value;
    const editErrornameTypeRooms = document.getElementById('editErrornameTypeRooms'+id);
    console.log(editNameTypeRooms)
    if (editNameTypeRooms.length > 20) {
        editErrornameTypeRooms.classList.remove('d-none');
        editErrornameTypeRooms.textContent = 'ข้อความยาวเกินไป';
        return;
    }

    if(editNameTypeRooms === ""){
        editErrornameTypeRooms.classList.remove('d-none');
        editErrornameTypeRooms.textContent = 'กรุณากรอกชื่อ'
        return;
    }
    editErrornameTypeRooms.classList.add('d-none');
    confirmEdit(id)
}

function validate_EditNumberUser(){
    const id = event.target.dataset.id;
    const editNumberUser = document.getElementById('editNumberUser'+id).value;
    const editErrorNumberUser = document.getElementById('editErrorNumberUser'+id);

    if (editNumberUser=== "") {
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

function confirmEdit(id){
    const editErrorNumberUser = document.getElementById('editErrorNumberUser'+id);
    const editErrornameTypeRooms = document.getElementById('editErrornameTypeRooms'+id);
    const editErrorTime = document.getElementById('editErrorTime'+id);
    const editButtonCreate = document.getElementById('editButtonCreate'+id);

    if (!editErrorNumberUser.classList.contains('d-none') && !editErrorTime.classList.contains('d-none') && !editErrornameTypeRooms.classList.contains('d-none')) {
        editButtonCreate.disabled = true;
    }else{
        editButtonCreate.disabled = false;
    }
}