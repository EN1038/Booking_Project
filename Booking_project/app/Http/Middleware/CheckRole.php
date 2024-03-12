<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
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
            if(auth()->user()->level_user === 'user'){
                return redirect('/');
            }else{
                return redirect('Login');
            }
            
        }else if(auth()->user()->level_user === 'admin'){
            return $next($request);
        }

    }
}