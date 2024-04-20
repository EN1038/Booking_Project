function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]; // ห้ามลืม ->แก้ไขตำแหน่งที่ต้องการค้นหา
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function checkStatus() {
    var tds = document.querySelectorAll('.form-css'); // เลือกทุกๆ element ที่มี class 'form-css'
    
    // วนลูปผ่าน NodeList
    tds.forEach(function(td) {
        var status = td.textContent.trim(); // ดึงข้อความที่อยู่ในแต่ละ element และตัดช่องว่างที่อยู่ข้างหน้าและหลังข้อความ
        
        // เปรียบเทียบค่าของ status และเพิ่มหรือลบ class ตามเงื่อนไข
        if (status === 'ยืนยันการจอง') {
            td.classList.remove('text-danger', 'text-warning');
            td.classList.add('text-success');
        } else if (status === 'ปฎิเสธการจอง') {
            td.classList.remove('text-success', 'text-warning');
            td.classList.add('text-danger');
        } else if (status === 'ยกเลิกการจอง') {
            td.classList.remove('text-success', 'text-danger');
            td.classList.add('text-warning');
        }
    });
}


checkStatus()
