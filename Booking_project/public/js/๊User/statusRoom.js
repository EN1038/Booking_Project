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
                window.location.href = herf+id+'/'+select.value;
            } else {
                select.value = status_now;
            }
        });
    } else{
        
    }

}