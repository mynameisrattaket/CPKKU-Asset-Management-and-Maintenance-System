<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermain;

class UsermainController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลผู้ใช้งานทั้งหมดจากโมเดล Usermain
        $users = Usermain::all();

        // ส่งข้อมูลผู้ใช้งานไปยังหน้า manageuser.index
        return view('manageuser.index', compact('users'));
    }

    public function create()
    {
        // ส่งกลับมาที่หน้าสร้างผู้ใช้ใหม่
        return view('manageuser.create');
    }

    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องและเก็บผู้ใช้งานใหม่
        $validatedData = $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_last_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:usermains|max:255',
            // เพิ่มกฎการตรวจสอบเพิ่มเติมตามที่ต้องการ
        ]);

        // สร้างผู้ใช้งานใหม่
        Usermain::create($validatedData);

        // ส่งกลับไปที่หน้า manageuser.index หรือแสดงข้อความสำเร็จ
        return redirect()->route('manageuser.index')->with('success', 'เพิ่มผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        // ค้นหาผู้ใช้งานด้วย ID และส่งไปยังหน้าแก้ไข
        $user = Usermain::findOrFail($id);
        return view('manageuser.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // ตรวจสอบความถูกต้องและอัปเดตผู้ใช้งาน
        $validatedData = $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_last_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            // เพิ่มกฎการตรวจสอบเพิ่มเติมตามที่ต้องการ
        ]);

        // ค้นหาผู้ใช้งานด้วย ID และอัปเดตข้อมูล
        $user = Usermain::findOrFail($id);
        $user->update($validatedData);

        // ส่งกลับไปที่หน้า manageuser.index หรือแสดงข้อความสำเร็จ
        return redirect()->route('manageuser.index')->with('success', 'อัปเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        // ค้นหาผู้ใช้งานด้วย ID และลบข้อมูล
        $user = Usermain::findOrFail($id);
        $user->delete();

        // ส่งกลับไปที่หน้า manageuser.index หรือแสดงข้อความสำเร็จ
        return redirect()->route('manageuser.index')->with('success', 'ลบข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }
}

