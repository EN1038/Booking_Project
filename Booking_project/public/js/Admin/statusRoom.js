function changStatus() {
    var select = event.target;
    var status_now = event.target.dataset.status;
    var id = event.target.dataset.id;
    var herf = 'http://127.0.0.1:8000/Update_status_admin/';
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
                window.location.href = herf+id+'/'+select.value;
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
                window.location.href = herf+id+'/'+select.value;
            } else {
                select.value = status_now;
            }
        });
    }

}

function checkStatus() {
    var select = document.querySelector('.form-select');
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