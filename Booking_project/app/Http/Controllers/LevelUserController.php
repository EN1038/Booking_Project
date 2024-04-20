<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leveluser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LevelUserController extends Controller
{
    //
    function login()
    {
        return view('Login.login');
    }
    function register()
    {
        return view('Login.register');
    }

    function insert_register(Request $request)
    {
        $hashedPassword = Hash::make($request->password);
        $register = new Leveluser();
        $register->name_user = $request->name_user;
        $register->passWordNumber_user = $request->passwordNumber_user;
        $register->email = $request->email;
        $register->level_user = $request->selectStatus;
        $register->goodness_user = 0;
        $register->status_user = 'จองได้';
        $register->password = $hashedPassword;
        $register->save();

        return back()->with('success', true);
    }

    function Authlogin(Request $request)
    {
        $credentials = $request->only('passWordNumber_user', 'password');

        if (Auth::attempt($credentials)) {
            // ตรวจสอบว่ามีผู้ใช้ล็อกอินแล้วหรือไม่
            if (Auth::check()) {
                // ได้ผู้ใช้ล็อกอินแล้ว ตรวจสอบสถานะของผู้ใช้
                $user = Auth::user();
                if ($user->level_user === 'admin'||$user->level_user === 'superAdmin') {
                    return redirect('DashBoard_Admin'); // หากเป็นแอดมินให้ไปยังหน้า dashboard
                } else {
                    return redirect('DashBoard_User'); // หากเป็น user ให้ไปยังหน้าหลัก
                }
            }
        }

        return back()->with('error', true);
    }


    function logout()
    {
        auth()->logout();
        return redirect('Login');
    }
}
