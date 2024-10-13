<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermain;
use App\Models\UserType;

class UsermainController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ที่มี user_type_id เท่ากับ 1 หรือ 5
        $users = Usermain::join('user_type', 'user.user_type_id', '=', 'user_type.user_type_id')
                         ->select('user.*', 'user_type.user_type_name')
                         ->whereIn('user.user_type_id', [1, 5]) // ใช้ whereIn เพื่อแสดง id 1 และ 5
                         ->get();

        $userTypes = UserType::all(); // ดึงข้อมูลประเภทผู้ใช้งานทั้งหมด

        return view('manageuser.index', compact('users', 'userTypes'));
    }


    public function technician()
    {
        $users = Usermain::join('user_type', 'user.user_type_id', '=', 'user_type.user_type_id')
                         ->select('user.*', 'user_type.user_type_name')
                         ->where('user.user_type_id', 2)
                         ->get();
        $userTypes = UserType::all(); // ดึงข้อมูลประเภทผู้ใช้งานทั้งหมด
        return view('manageuser.technician', compact('users', 'userTypes'));
    }

    public function employee()
    {
        $users = Usermain::join('user_type', 'user.user_type_id', '=', 'user_type.user_type_id')
                         ->select('user.*', 'user_type.user_type_name')
                         ->whereIn('user.user_type_id', [3, 4])
                         ->get();
        $userTypes = UserType::all(); // ดึงข้อมูลประเภทผู้ใช้งานทั้งหมด
        return view('manageuser.employee', compact('users', 'userTypes'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_major' => 'required|string|max:255',
            'user_type_id' => 'required|integer',
        ]);

        $user = Usermain::findOrFail($id);
        $user->update($validatedData);

        return redirect()->back()->with('success', 'อัปเดตข้อมูลผู้ใช้งานสำเร็จ');
    }


    public function destroy($id)
    {
        $user = Usermain::findOrFail($id);
        $user->delete();

        return back()->with('success', 'ลบข้อมูลผู้ใช้สำเร็จ');
    }
}
