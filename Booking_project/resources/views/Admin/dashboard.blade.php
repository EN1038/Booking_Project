@extends('Layout.layout_admin.layout')
@section('content')
{{Auth::user()->name_user;}}
<h1>Main Page Admins Building..</h1>
<a href="{{route('logout')}}" class="btn btn-primary">Logout</a>
    
@endsection