<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermain;

class UsermainController extends Controller
{
    public function index()
    {
        $users = Usermain::where('user_type_id', 1)->get();
        return view('manageuser.index', compact('users'));
    }

    public function technician()
    {
        $users = Usermain::where('user_type_id', 2)->get();
        return view('manageuser.technician', compact('users'));
    }
    public function employee()
    {
        $users = Usermain::whereIn('user_type_id', [3, 4])->get();
        return view('manageuser.employee', compact('users'));
    }




    public function create()
    {
        return view('manageuser.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_last_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:usermains|max:255',
            'user_password' => 'required|string|min:6', // เพิ่ม validation สำหรับรหัสผ่าน
            'faculty_faculty_id' => 'required|string|max:255', // เพิ่ม validation สำหรับคณะ
            'user_major' => 'required|string|max:255', // เพิ่ม validation สำหรับสาขาวิชา
            'user_type_id' => 'required|string|max:255', // เพิ่ม validation สำหรับสถานะผู้ใช้งาน
        ]);

        $validatedData['user_password'] = bcrypt($request->user_password); // นำรหัสผ่านมาเข้ารหัสก่อนบันทึก

        Usermain::create($validatedData);

        return redirect()->route('manageuser.index')->with('success', 'เพิ่มผู้ใช้งานสำเร็จ');
    }

    public function edit($id)
    {
        $user = Usermain::findOrFail($id);
        return view('manageuser.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_last_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'faculty_faculty_id' => 'required|string|max:255',
            'user_major' => 'required|string|max:255',
            'user_type_id' => 'required|string|max:255',
        ]);

        $user = Usermain::findOrFail($id);
        $user->update($validatedData);

        return redirect()->route('manageuser.index')->with('success', 'อัปเดตข้อมูลผู้ใช้งานสำเร็จ');
    }

    public function destroy($id)
    {
        $user = Usermain::findOrFail($id);
        $user->delete();

        return redirect()->route('manageuser.index')->with('success', 'ลบข้อมูลผู้ใช้สำเร็จ');
    }
}

