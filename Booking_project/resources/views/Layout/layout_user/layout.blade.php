<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking | DashBoardUser</title>
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
<body class="container">
    <nav class="d-flex flex-row justify-content-center align-items-center p-3 bg-primary text-light">
        <div class="col">
            <span>User | DashBoard</span>
        </div>
        <div class="col d-flex flex-row justify-content-end  align-items-center ">
            <a href="{{route('dashboard_admin')}}" class="mx-3 link-light text-decoration-none">จองห้อง</a>
            <a href="{{ route('history', Auth::user()->id) }}" class="mx-3 link-light text-decoration-none">เช็คสถานะการจอง</a>
            <a href="{{route('create_room')}}" class="mx-3 link-light text-decoration-none">Create Room</a>
            @if (Auth::check())
            <a href="#" class="mx-3 link-light text-decoration-none">{{Auth::user()->name_user;}}</a>
            <a href="{{route('logout')}}" class="mx-3 link-light text-decoration-none">Logout</a>
            @else
            <a href="{{route('login')}}" class="mx-3 link-light text-decoration-none">Login</a>
            @endif
            
            
        </div>
    </nav>    
    @yield('content')
    <footer class="d-flex flex-row justify-content-center align-items-center p-3 bg-primary text-light">
        <span>Footer</span>
    </footer>
</body>
</html>