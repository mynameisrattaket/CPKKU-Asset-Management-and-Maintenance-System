<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $allowedUserTypes
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$allowedUserTypes)
    {
        // ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
        $user = Auth::user();

        // ถ้าไม่ได้ล็อกอินให้ไปที่หน้า login
        if (!$user) {
            return redirect()->route('login'); // หรือหน้าอื่น ๆ ที่คุณต้องการให้ไปเมื่อไม่ได้ล็อกอิน
        }

        // ตรวจสอบว่า user type ตรงกับที่กำหนดหรือไม่
        if (!in_array($user->user_type_id, $allowedUserTypes)) {
            return redirect()->route('index')->with('error', 'การเข้าถึงถูกจำกัดสำหรับผู้ใช้บางประเภท');
        }

        return $next($request);
    }
}
