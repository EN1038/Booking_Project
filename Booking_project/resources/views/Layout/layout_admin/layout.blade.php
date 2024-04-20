<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking | DashBoardAdmins</title>
</head>

{{-- Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

{{-- Sweetaa Alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Font Awesome --}}
<script src="https://kit.fontawesome.com/fee57be653.js" crossorigin="anonymous"></script>

{{-- Font --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400&family=Rubik:wght@400&display=swap" rel="stylesheet">

{{-- CSS --}}
<link rel="stylesheet" href="{{asset('css/Admin/layout.css')}}">
<body>
    {{-- <nav class="d-flex flex-row justify-content-center align-items-center p-3 bg-dark text-light">
        <div class="col">
            <span>Admin | DashBoard</span>
        </div>
        <div class="col d-flex flex-row justify-content-end  align-items-center ">
            <a href="{{route('dashboard_admin')}}" class="mx-3 link-light text-decoration-none">หน้าแรก</a>
            <a href="{{route('create_room')}}" class="mx-3 link-light text-decoration-none">สร้างห้อง</a>
            <a href="{{route('status_room')}}" class="mx-3 link-light text-decoration-none">จองห้อง</a>
            <a href="{{route('history_room')}}" class="mx-3 link-light text-decoration-none">ประวัติ</a>
            @if (Auth::check())
            <a class="mx-3 link-light text-decoration-none">{{Auth::user()->name_user;}}</a>
            <a href="{{route('logout')}}" class="mx-3 link-light text-decoration-none">ออกจากระบบ</a>
            @else
            <a href="{{route('login')}}" class="mx-3 link-light text-decoration-none">เข้าสู่ระบบ</a>
            @endif
            
            
        </div>
    </nav> --}}
    
    {{-- SideBar --}}
    <div id="mySidenav" class="sidenav">
        <div class="d-flex flex-column text-white p-3 costome-hight">
          <div class="d-flex flex-row mb-4 ">
            <div class="col-4 text-center">
                <i class="fa-solid fa-layer-group fs-3"></i>
            </div>
            <div class="col fs-5 fw-bold d-flex align-items-center text-greenlight">
              <span class="divToHide ">Booking NSRU</span>
            </div>
          </div>
          <div class="d-flex flex-row align-items-center mb-3">
            <div class="col-4">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Unknown_person.jpg/694px-Unknown_person.jpg" alt="" class="user-img-scale rounded-3" id="profiles">
            </div>
            <div class="col-8 " >
              <div class="d-flex flex-column divToHide" >
                @if(Auth::check())
                <div class="col"><span >{{Auth::user()->name_user}}</span></div>
                <div class="col"><span >{{Auth::user()->passWordNumber_user}}</span></div>
  
                @else
                <div class="col"><span >USERNAME</span></div>
                <div class="col"><span >USERS_ID</span></div>
                @endif
              </div>
            </div>
          </div>
          @if(Auth::check())
          <div class="text-start ps-1 mb-2">
            <span class="text-title ">หัวข้อหลัก</span>
          </div>
          <a href="{{route('dashboard_admin')}}" class="text-decoration-none">
            <div class="hover-btn d-flex flex-row mb-1 rounded-3  align-items-center">
              <div class="col-2 fs-4 text-center">
                <i class="fa-solid fa-house"></i>
              </div>
              <div class="col d-flex align-items-center justify-content-center fs-7 ">
                <span class="divToHide ">หน้าแรก</span>
              </div>
            </div>
          </a>
          @if(Auth::user()->level_user === 'superAdmin')
              <a href="{{ route('create_room') }}" class="text-decoration-none">
                  <div class="hover-btn d-flex flex-row mb-1 rounded-3 align-items-center">
                      <div class="col-2 fs-4 text-center">
                          <i class="fa-solid fa-folder-plus"></i>
                      </div>
                      <div class="col d-flex align-items-center justify-content-center fs-7">
                          <span class="divToHide">สร้างห้อง</span>
                      </div>
                  </div>
              </a>
              <a href="{{ route('create_typeroom') }}" class="text-decoration-none">
                  <div class="hover-btn d-flex flex-row mb-1 rounded-3 align-items-center">
                      <div class="col-2 fs-4 text-center">
                          <i class="fa-solid fa-circle-plus"></i>
                      </div>
                      <div class="col d-flex align-items-center justify-content-center fs-7">
                          <span class="divToHide">สร้างประเภทห้อง</span>
                      </div>
                  </div>
              </a>
          @endif

          <a href="{{route('status_room')}}" class="text-decoration-none">
            <div class="hover-btn d-flex flex-row mb-1 rounded-3  align-items-center">
              <div class="col-2 fs-4 text-center">
                <i class="fa-solid fa-square-check"></i>
              </div>
              <div class="col d-flex align-items-center justify-content-center fs-7">
                <span class="divToHide ">อนุมัติการจอง</span>
              </div>
            </div>
          </a>
          <a href="{{route('history_room')}}" class="text-decoration-none">
            <div class="hover-btn d-flex flex-row mb-1 rounded-3  align-items-center">
              <div class="col-2 fs-4 text-center">
                <i class="fa-solid fa-clipboard"></i>
              </div>
              <div class="col d-flex align-items-center justify-content-center fs-7">
                <span class="divToHide ">ประวัติ</span>
              </div>
            </div>
          </a>
          <div class="text-start ps-1 mb-2">
            <span class="text-title ">หัวข้อรอง</span>
          </div>
          <a href="{{route('booking_admin')}}" class="text-decoration-none">
            <div class="hover-btn d-flex flex-row mb-1 rounded-3  align-items-center">
              <div class="col-2 fs-4 text-center">
                <i class="fa-solid fa-bookmark"></i>
              </div>
              <div class="col d-flex align-items-center justify-content-center fs-7">
                <span class="divToHide ">จองห้อง</span>
              </div>
            </div>
          </a>
        </div>
        <div class="d-flex flex-column text-white px-3 ">
          <div class="text-start ps-1 mb-2">
            <span class="text-title ">จัดการ</span>
          </div>
          <div class="text-decoration-none">
  
            <a href="{{route('logout')}}" class="hover-btn-logout d-flex flex-row rounded-3  align-items-center">
                <div class="col-2 fs-4 text-center">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </div>
                <div class="col d-flex align-items-center justify-content-center fs-7">
                  <span class="divToHide ">ออกจากระบบ</span>
                </div>
              </a>
            @else
            <a href="{{route('login')}}" class="hover-btn-logout d-flex flex-row rounded-3  align-items-center my-3">
                <div class="col-2 fs-4 text-center">
                  <i class="fa-solid fa-right-to-bracket"></i>
                </div>
                <div class="col d-flex align-items-center justify-content-center fs-7">
                  <span class="divToHide ">เข้าสู่ระบบ</span>
                </div>
            </a>
            <a href="{{route('register')}}" class="hover-btn-logout d-flex flex-row rounded-3  align-items-center">
                <div class="col-2 fs-4 text-center">
                  <i class="fa-solid fa-circle-up"></i>
                </div>
                <div class="col d-flex align-items-center justify-content-center fs-7">
                  <span class="divToHide ">สมัครการเข้าใช้งาน</span>
                </div>
              </a>
            @endif
          </div>
        </div>
      </div>
      {{-- End Side Bar --}}
      <div class="box wrapper" id="main">
        {{-- Start_sidenav --}}
        <div class="row border-bottom ">
            <div class="d-none d-md-flex col-3 p-0 d-flex align-items-center">

                <div class=" text-end text-icon-toggle" id="openNavButton" onclick="toggleNav()" style="cursor: pointer;">
                  <span class="scale-icon-nav " id="openNavIcon" onclick="openNav()">
                    <i class="fa-solid fa-caret-up fa-rotate-90"></i>
                  </span>
                  <span class="scale-icon-nav " id="closeNavIcon" onclick="closeNav()">
                    <i class="fa-solid fa-caret-up fa-rotate-270"></i>
                  </span>
                </div>
                <div class="col">
                  <span class="text-success text-logo">Booking NSRU</span>
                </div>

            </div>
            <div class="col ">
                <div class=" d-none d-sm-flex justify-content-sm-center justify-content-md-end">
                    <div class="ms-3 py-4 nav-link">
                            @if(Auth::check())
                            

                            <a href="{{route('dashboard_admin')}}"
                            class=' mx-2'><i class="bi bi-plus-circle-fill "></i> หน้าแรก</a>
                            @if(Auth::user()->level_user === 'superAdmin')
                            <a href="{{route('create_room')}}"
                            class=' mx-2'><i class="bi bi-clipboard2-check-fill"></i> สร้างห้อง</a>

                            <a href="{{route('create_typeroom')}}"
                            class=' mx-2'><i class="bi bi-pie-chart-fill"></i> สร้างประเภทห้อง</a>
                            @endif
                            <a href="{{route('status_room')}}"
                            class=' mx-2'><i class="bi bi-pie-chart-fill"></i> อนุมัติการจอง</a>

                            <a href="{{route('history_room')}}"
                            class=' mx-2'><i class="bi bi-pie-chart-fill"></i> ประวัติ</a>

                            <a href="{{route('logout')}}"
                            class=" mx-2 "><i class="bi bi-box-arrow-left"></i> ออกจากระบบ</a>
                            @else

                            <a href="{{route('login')}}"
                    class=" mx-3 "><i class="fa-solid fa-right-to-bracket"></i> เข้าสู่ระบบ</a>

                            <a href="{{route('register')}}"
                            class=" mx-2 "><i class="fa-solid fa-circle-up"></i> สมัครสมาชิก</a>
                            @endif
                    </div>

                </div>
                <div class="list-nav-sidebar d-flex d-sm-none justify-content-between ms-3 py-sm-4 ">
                  <span class="text-success fw-bold">Booking NSRU</span>
                  <div class="dropdown">
                  <button class="dropdown-btn"><i class="fa-solid fa-bars fs-4 "></i></button>
                  <div class="dropdown-content">
                    @if(Auth::check())
                            

                            <a href="{{route('dashboard_admin')}}"
                            class=' mx-2'><i class="bi bi-plus-circle-fill "></i> หน้าแรก</a>

                            <a href="{{route('create_room')}}"
                            class=' mx-2'><i class="bi bi-clipboard2-check-fill"></i> สร้างห้อง</a>
                            @if(Auth::user()->level_user === 'superAdmin')
                            <a href="{{route('create_typeroom')}}"
                            class=' mx-2'><i class="bi bi-pie-chart-fill"></i> สร้างประเภทห้อง</a>

                            <a href="{{route('status_room')}}"
                            class=' mx-2'><i class="bi bi-pie-chart-fill"></i> อนุมัติการจอง</a>
                            @endif
                            <a href="{{route('history_room')}}"
                            class=' mx-2'><i class="bi bi-pie-chart-fill"></i> ประวัติ</a>

                            <a href="{{route('logout')}}"
                            class=" mx-2 "><i class="bi bi-box-arrow-left"></i> ออกจากระบบ</a>
                            @else

                            <a href="{{route('login')}}"
                    class=" mx-3 "><i class="fa-solid fa-right-to-bracket"></i> เข้าสู่ระบบ</a>

                            <a href="{{route('register')}}"
                            class=" mx-2 "><i class="fa-solid fa-circle-up"></i> สมัครสมาชิก</a>
                            @endif
                  </div>
                </div>
                </div>
            </div>
        </div>
        {{-- End_sidenav --}}
        {{-- body --}}
        <div class="body glassmorphism-body mt-4">
            @yield('content')
        </div>
        {{-- End_body --}}
        {{-- Footer --}}
        <footer class="footer text-light">
          <div class="container py-3">
            <div class="text-muted text-center">NSRU Nakhon Sawan Rajabhat University <br>
              NSRU All Rights Reserved</div>
          </div>
        </footer>
        {{-- End_Footer --}}
    </div>
    {{-- End_main --}}

    
    <script src="{{asset('js/Admin/layout_admin.js')}}"></script>
</body>
</html>