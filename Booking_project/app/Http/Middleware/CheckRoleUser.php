<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->level_user != 'admin') {
            // หากไม่ได้รับอนุญาตให้เข้าถึง ทำการ Redirect ไปยังหน้าที่เหมาะสม
            return redirect('Login');
        }else{
            return redirect('DashBoard_Admin');
        }
    }
}
