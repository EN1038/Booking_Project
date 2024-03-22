<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leveluser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LevelUserController extends Controller
{
    //
    function login(){
        return view('Login.login');
    }
    function register(){
        return view('Login.register');
    }

    function insert_register(Request $request){
        $hashedPassword = Hash::make($request->password);
        $register = new Leveluser();
        $register->name_user = $request->name_user;
        $register->email = $request->email;
        $register->level_user = $request->selectStatus;
        $register->password = $hashedPassword;
        $register->save();

        return back()->with('success', true);
    }

    function Authlogin(Request $request)
    {
        // dd($request);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('DashBoard_Admin'); // Redirect ไปยังหน้าที่ผู้ใช้งานเข้ามาจากก่อนหน้า
        }
        return back();
    }

    function logout()
    {
        auth()->logout();
        return redirect('Login');
    }

    
}
