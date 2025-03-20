<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermain;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
class UsermainController extends Controller
{
    public function index(Request $request)
    {
        // ถ้ามีการกรองสถานะจาก request
        $filterStatus = $request->input('status', 'all'); // ค่าเริ่มต้นเป็น 'all' (แสดงทั้งหมด)

        // ถ้ากรองสถานะ, ใช้ where หรือ whereIn
        if ($filterStatus === 'all') {
            // กรณีแสดงทั้งหมด
            $users = Usermain::leftJoin('user_type', 'user.user_type_id', '=', 'user_type.user_type_id')
                             ->select('user.*', 'user_type.user_type_name')
                             ->orderBy('user.id') // เรียงลำดับตาม id
                             ->get();
        } else {
            // กรองตาม user_type_id ที่เลือก
            $users = Usermain::leftJoin('user_type', 'user.user_type_id', '=', 'user_type.user_type_id')
                             ->select('user.*', 'user_type.user_type_name')
                             ->where('user.user_type_id', $filterStatus)
                             ->orderBy('user.id') // เรียงลำดับตาม id
                             ->get();
        }

        // ดึงข้อมูลประเภทผู้ใช้งานทั้งหมด
        $userTypes = UserType::all();

        return view('manageuser.index', compact('users', 'userTypes'));
    }

    public function store(Request $request)
    {
        // การตรวจสอบข้อมูลที่กรอก
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email|max:255',
            'user_type_id' => 'required|integer',
        ]);

        // สร้างผู้ใช้งานใหม่
        Usermain::create($validatedData);

        return redirect()->route('manageuser.index')->with('success', 'เพิ่มข้อมูลผู้ใช้งานสำเร็จ');
    }




    public function update(Request $request, $id)
    {
        // ใช้ 'nullable' และ 'sometimes' เพื่อให้สามารถอัปเดตเฉพาะฟิลด์ที่ต้องการได้
        $validatedData = $request->validate([
            'user_major' => 'nullable|string|max:255',  // ไม่บังคับต้องกรอกถ้าไม่มีการเปลี่ยนแปลง
            'user_type_id' => 'nullable|integer',      // ไม่บังคับต้องกรอกถ้าไม่มีการเปลี่ยนแปลง
        ]);

        $user = Usermain::findOrFail($id);

        // อัปเดตเฉพาะฟิลด์ที่ได้รับการส่งมา
        $user->update($validatedData);

        return redirect()->route('manageuser.index')->with('success', 'อัปเดตข้อมูลผู้ใช้งานสำเร็จ');
    }



    public function destroy($id)
    {
        // ตรวจสอบก่อนว่ามีข้อมูลใน request_repair ที่เชื่อมโยงกับผู้ใช้งานนี้หรือไม่
        $user = Usermain::findOrFail($id);

        // อัปเดตข้อมูลใน request_repair ให้ user_user_id เป็น NULL
        DB::table('request_repair')
            ->where('user_user_id', $id)
            ->update(['user_user_id' => null]);

        // ลบผู้ใช้งานจากตาราง user
        $user->delete();

        return redirect()->route('manageuser.index')->with('success', 'ลบข้อมูลผู้ใช้สำเร็จ');
    }



}
