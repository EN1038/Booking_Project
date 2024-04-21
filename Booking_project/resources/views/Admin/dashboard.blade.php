@extends('Layout.layout_admin.layout')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{asset('css/Admin/dashBoardAdmin.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'สำเร็จ!',
        text: '{{ session('success') }}',
        icon: 'success'
    });
</script>
@elseif (session('error'))
<script>
    Swal.fire({
    title: 'ผิดพลาด!',
    text: '{{ session('error') }}',
    icon: 'error'
});
</script>
@endif
<div class="row">
  <div class="col-sm-3">
    <a href="{{route('status_room')}}" class="text-decoration-none">
      <div class="card border-success ">
        <div class="card-body">
          <div class="row text-center">
            <div class="col">
              <i class="fa-solid fa-square-check icon-card"></i>
            </div>
            <div class="col">
                <p class="m-0 title-card">รอการอนุมัติ</p>
                <p class="m-0 value-card " id="wait">{{$count_status_booking_wait}} คน</p>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <script>
    function fetchData() {
  fetch('/api/count_status_booking_wait')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      // ทำสิ่งที่คุณต้องการกับข้อมูลที่ได้รับ
      // console.log(data);
      var wait = document.getElementById('wait');
      wait.textContent = data + ' คน';
      if(data != 0){
        wait.classList.add('text-danger')
      }else{
        wait.classList.remove('text-danger','fw-bold')
      }
    })
    .catch(error => {
      console.error('There was a problem with the fetch operation:', error);
    });
}

// เรียกใช้ fetchData() เพื่อดึงข้อมูลเริ่มต้น
fetchData();

// เรียกใช้ fetchData() ทุกๆ 10 วินาที
setInterval(fetchData, 10000); // 10000 มิลลิวินาที = 10 วินาที

  </script>
  <div class="col-sm-3">
    <a href="{{route('history_room')}}" class="text-decoration-none">
      <div class="card border-success ">
        <div class="card-body">
          <div class="row text-center">
            <div class="col">
              <i class="fa-solid fa-user-check icon-card"></i>
            </div>
            <div class="col">
                <p class="m-0 title-card">ยืนยันการจอง</p>
                <p class="m-0 value-card ">{{$count_status_booking_success}} คน</p>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-3">
    <a href="{{route('history_room')}}" class="text-decoration-none">
      <div class="card border-success ">
        <div class="card-body">
          <div class="row text-center">
            <div class="col">
              <i class="fa-solid fa-user-xmark icon-card"></i>
            </div>
            <div class="col">
                <p class="m-0 title-card">ปฎิเสธการจอง</p>
                <p class="m-0 value-card ">{{$count_status_booking_insuccess}} คน</p>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
    <div class="col-sm-3">
      <div class="card border-success ">
        <div class="card-body">
          <div class="row text-center">
            <div class="col">
              <i class="fa-solid fa-users icon-card"></i>
            </div>
            <div class="col">
                <p class="m-0 title-card">คำขอทั้งหมด</p>
                <p class="m-0 value-card">{{$count_status_booking}} คน</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-8 py-1 pe-3">
      <select class="form-select text-center border border-success mb-1 rounded-5" id="select_type" onchange="checkSelect(this)">
        <option selected disabled hidden>เลือกประเภทของห้องที่ต้องการดู</option>
        @foreach ($typeRoom as $item)
        <option value="{{$item}}">{{$item}}</option>
        @endforeach
      </select>
      <input type="text" id="datePicker" placeholder="เลือกวันที่ที่ต้องการค้นหา" class="w-100 rounded-5 border border-success text-center p-1 mb-1 d-none">
      <canvas id="myChart" width="530" height="250" class="border border-success rounded-4 p-3 " ></canvas>
    </div>
    <div class="col-lg-4 py-1 ps-3">
      <select class="form-select text-center border border-success mb-1 rounded-5" id="select_type_pie" onchange="checkSelectPie(this)">
        <option selected disabled hidden>เลือกประเภทของห้องที่ต้องการดู</option>
        @foreach ($typeRoom as $item)
        <option value="{{$item}}">{{$item}}</option>
        @endforeach
      </select>
      <input type="text" id="datePickerPie" placeholder="เลือกเดือนที่ที่ต้องการค้นหา" class="w-100 rounded-5 border border-success text-center p-1 mb-1 d-none">
      <canvas id="myChartPie" width="auto" height="150" class="border border-success rounded-4 p-3 "></canvas>
    </div>
  </div>
  <div class="row mt-1">
    <div class="col-lg-8 py-1 pe-3 ">
      <div class="pt-4">
      <input type="text" id="datePickerTotal" placeholder="เลือกวันที่ที่ต้องการค้นหา" class="w-100 rounded-5 border border-success text-center p-1 mb-1">
            <div class="card border-success rounded-4 w-100">
              <div class="card-body">
                <div class="row text-center">
                  <div class="col">
                    <i class="fa-solid fa-users icon-card"></i>
                  </div>
                  <div class="col">
                      <p class="m-0 title-card">จำนวนทั้งหมดต่อเดือน</p>
                      <p class="m-0 value-card " id="Total"> คน</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
    <div class="col-lg-4 py-1 ps-3 d-flex align-items-center">
      <div class="border border-success rounded-4 p-3 ">
        <div class="row px-4 py-2">
          <p class="text-secondary text-center fw-bold fs-5">กดเพื่อเปลี่ยนโหมดห้องทั้งหมด</p>
          <p class="text-dark text-center fw-bold fs-5">สถานะห้อง<span class="fs-3 
            {{ $message === 'ห้องทั้งหมดเปิดใช้งาน' ? 'text-success' :
               ($message === 'ห้องทั้งหมดปิดการใช้งาน' ? 'text-danger' :
               'text-info') }}"> {{$message}}</span>
        </p>        
          <a href="{{route('all_change_status')}}" class="btn btn-success rounded-5 fs-4">
            <i class="fa-solid fa-power-off"></i> เปิด หรือ ปิด
          </a>
        </div>
      </div>
    </div>
  </div>

<script>
  function checkSelect(){
    var value = event.target;
    var myChart = document.getElementById('datePicker');
    myChart.classList.remove('d-none');
    myChart.value = '';

  }

  document.addEventListener('DOMContentLoaded', function () {   

    // สร้าง flatpickr เพื่อให้เลือกวันที่
    flatpickr("#datePicker", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            // เมื่อวันที่เปลี่ยน ให้ดึงข้อมูลใหม่และอัปเดตกราฟ
            updateChart(dateStr);
        }
    });

    // เรียกใช้ฟังก์ชันสำหรับการอัปเดตกราฟเมื่อโหลดเพจ
    updateChart();
    
    // ฟังก์ชันสำหรับอัปเดตข้อมูลในกราฟ
function updateChart(selectedDate = null) {
    // สร้าง URL สำหรับการดึงข้อมูล ถ้าไม่มีวันที่ที่เลือก ให้ใช้วันที่ปัจจุบัน
    var select = document.getElementById('select_type').value;
    const url = selectedDate ? `/api/bookingData?date=${selectedDate}&select=${select}` : '/api/bookingData';

    // เชื่อมต่อไปยัง API เพื่อรับข้อมูลการจอง
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            const backgroundColor = Array.from({ length: data.length }, () => getRandomColor());
            const total = data.reduce((acc, item) => acc + item.count, 0);
          data.push({ name_room: 'รวม', count: total });
            const labels = data.map(item => item.name_room);
            const dataTotal = data.map(item => item.count);

            var ctx = document.getElementById('myChart').getContext('2d');

            // ถ้ามี myChart แล้วให้ทำลายกราฟเดิมก่อน
            if(window.myChart instanceof Chart)
            {
                window.myChart.destroy();
            }

            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'จำนวนคนที่เข้าใช้งานห้องนี้',
                        data: dataTotal,
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor.map(color => color.replace('0.2', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                  plugins: {
                        title: {
                            display: true,
                            text: 'ข้อมูลการจองห้องตามวัน', // ข้อความที่จะแสดงเป็น title
                            font: {
                                size: 18 // ขนาดตัวอักษรของ title
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}



    // ฟังก์ชันสำหรับสร้างสีสุ่ม
    function getRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r}, ${g}, ${b}, 0.2)`;
    }
});
</script>

<script>
  function checkSelectPie(){
    var value = event.target;
    var myChart = document.getElementById('datePickerPie');
    myChart.classList.remove('d-none');
    myChart.value = '';

  }

 


    document.addEventListener('DOMContentLoaded', function () {
      flatpickr("#datePickerPie", {
    dateFormat: "Y-m", // รูปแบบวันที่เป็นปี-เดือน (YYYY-MM)
    onChange: function(selectedDates, dateStr, instance) {
        // เมื่อเลือกวันที่เปลี่ยน ให้ดึงเดือนจากวันที่ที่เลือกและส่งไปยังฟังก์ชัน updateChart
        const selectedMonth = dateStr.substring(0, 7); // ตัดเฉพาะส่วนของปี-เดือน (YYYY-MM)
        // console.log(selectedMonth)
        updateChart(selectedMonth);
    }
});

updateChart();
      function updateChart(selectedMonth = null) {
    // สร้าง URL สำหรับการดึงข้อมูล ถ้าไม่มีวันที่ที่เลือก ให้ใช้วันที่ปัจจุบัน
    var select = document.getElementById('select_type_pie').value;
    const url = selectedMonth ? `/api/bookingDatapie?month=${selectedMonth}&select=${select}` : '/api/bookingDatapie';

    // เชื่อมต่อไปยัง API เพื่อรับข้อมูลการจอง
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            const backgroundColor = Array.from({ length: data.length }, () => getRandomColor());
            const total = data.reduce((acc, item) => acc + item.count, 0);
        data.push({ name_room: 'รวม', count: total });
            const labels = data.map(item => item.name_room);
            const dataTotal = data.map(item => item.count);

            var ctx = document.getElementById('myChartPie').getContext('2d');

            // ถ้ามี myChart แล้วให้ทำลายกราฟเดิมก่อน
            if(window.myChartPie instanceof Chart)
            {
                window.myChartPie.destroy();
            }

            myChartPie = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'จำนวนคนที่เข้าใช้งานห้องนี้',
                        data: dataTotal,
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor.map(color => color.replace('0.2', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                  plugins: {
                        title: {
                            display: true,
                            text: 'ข้อมูลการจองห้องตามเดือน', // ข้อความที่จะแสดงเป็น title
                            font: {
                                size: 18 // ขนาดตัวอักษรของ title
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

});

function getRandomColor() {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return `rgba(${r}, ${g}, ${b}, 0.2)`;
}
 
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      flatpickr("#datePickerTotal", {
    dateFormat: "Y-m", // รูปแบบวันที่เป็นปี-เดือน (YYYY-MM)
    onChange: function(selectedDates, dateStr, instance) {
        // เมื่อเลือกวันที่เปลี่ยน ให้ดึงเดือนจากวันที่ที่เลือกและส่งไปยังฟังก์ชัน updateChart
        const selectedMonths = dateStr.substring(0, 7); // ตัดเฉพาะส่วนของปี-เดือน (YYYY-MM)
        // console.log(selectedMonth)
        updatedTotal(selectedMonths);
    }
  });
  updatedTotal();
  function updatedTotal(selectedMonths = null){
    // console.log(selectedMonths)
    const url = selectedMonths ? `/api/bookingDataTotal?month=${selectedMonths}` : '/api/bookingDataTotal';
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        // ทำสิ่งที่คุณต้องการกับข้อมูลที่ได้รับ
        // console.log(data);
        var Total = document.getElementById('Total');
        Total.textContent = data + ' คน';
      })
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
  }
  })
</script>

   
@endsection