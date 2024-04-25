<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leveluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use NSRU\App;
use NSRU\DataCore;
use NSRU\MyAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $appId;
    private $appSecret;
    private App $app;
    private MyAuth $myauth;
    private DataCore $dc;

    public function __construct()
    {
        $this->appId = env('NSRU_APP_ID');
        $this->appSecret = env('NSRU_APP_SECRET');
        $this->app = new App($this->appId, $this->appSecret);
        $this->myauth = $this->app->createMyAuth();
        $this->dc = $this->app->createDataCore();
    }

    public function signin()
    {
        $url = route('user.signinCallback');
        $signinUrl = $this->myauth->getSigninURL($url);
        return redirect($signinUrl);
    }

    public function signinCallback(Request $request)
    {
        $username = $request->input('username');
        $email = $username . '@nsru.ac.th';
        $this->myauth->doSigninPostback();

        if ($staff = $this->dc->find_staff($username)) {

            if ($user = Leveluser::where('email', $email)->first()) {
                Auth::login($user);
            } else {
                $user = new Leveluser();
                $user->email = $email;
                $user->name_user = $staff->first_name;
                $user->last_name = $staff->last_name;
                $user->passWordNumber_user = $staff->ldap_username;
                $user->level_user = 'user';
                $user->goodness_user = 0;
                $user->status_user = 'จองได้';
                $user->cool_down_user = null;
                $user->image = $staff->portrait_image;
                $user->password = Hash::make(Str::random(30));
                $user->save();
                Auth::login($user);
            }
            if (Auth::check()) {
                // ได้ผู้ใช้ล็อกอินแล้ว ตรวจสอบสถานะของผู้ใช้
                $user = Auth::user();
                if ($user->level_user === 'admin' || $user->level_user === 'superAdmin') {
                    return redirect('DashBoard_Admin'); // หากเป็นแอดมินให้ไปยังหน้า dashboard
                } else {
                    return redirect('DashBoard_User'); // หากเป็น user ให้ไปยังหน้าหลัก
                }
            }
        } elseif ($student = $this->dc->find_student($username)) {
            if ($user = Leveluser::where('email', $email)->first()) {
                Auth::login($user);
            } else {
                $user = new Leveluser();
                $user->email = $email;
                $user->name_user = $student->first_name;
                $user->last_name = $student->last_name;
                $user->passWordNumber_user = $student->ldap_username;
                $user->level_user = 'user';
                $user->goodness_user = 0;
                $user->status_user = 'จองได้';
                $user->cool_down_user = null;
                $user->image = $student->portrait_image;
                $user->password = Hash::make(Str::random(30));
                $user->save();
                Auth::login($user);
            }
            if (Auth::check()) {
                // ได้ผู้ใช้ล็อกอินแล้ว ตรวจสอบสถานะของผู้ใช้
                $user = Auth::user();
                if ($user->level_user === 'admin' || $user->level_user === 'superAdmin') {
                    return redirect('DashBoard_Admin'); // หากเป็นแอดมินให้ไปยังหน้า dashboard
                } else {
                    return redirect('DashBoard_User'); // หากเป็น user ให้ไปยังหน้าหลัก
                }
            }
        } else {
        }
    }

    public function signout()
    {
        $url = route('user.signoutCallback');
        $signoutUrl = $this->myauth->getSignoutURL($url);
        return redirect($signoutUrl);
    }

    public function signoutCallback()
    {
        Auth::logout();
        session()->flush();
        $this->myauth->doSignoutPostback();
        return redirect('/');
    }
}
