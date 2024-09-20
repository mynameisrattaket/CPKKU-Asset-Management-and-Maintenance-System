<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('token')) {
            return redirect('/login')->with('error', 'กรุณาล็อกอินเพื่อเข้าถึงข้อมูลนี้');
        }

        return $next($request);
    }
}

