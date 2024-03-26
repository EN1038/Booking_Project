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