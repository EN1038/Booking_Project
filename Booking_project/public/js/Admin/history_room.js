function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[4]; // ห้ามลืม ->แก้ไขตำแหน่งที่ต้องการค้นหา
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
    var td = document.querySelector('.form-css');
    var status = td.textContent;

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
}

checkStatus()