<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Asset;
// ใช้งานคลาส Illuminate\Http\Request แทน
use Illuminate\Http\Request;


if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    die('Autoload file not found. Please run "composer install" to install dependencies.');
}


// กำหนดให้แอปพลิเคชันอยู่ในโหมดการบำรุงรักษาหรือไม่
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// ลงทะเบียน Autoloader ของ Composer
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel และจัดการ Request...
(require_once __DIR__.'/../bootstrap/app.php')->handleRequest(Request::capture());

class AssetController extends Controller
{
    public function storeFromExcel(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->back()->with('error', 'Method not allowed');
        }

        
        // ตรวจสอบว่ามีการเรียกใช้งานผ่านเมธอด GET และส่งไปยัง URL store-asset-from-excel
        if ($request->isMethod('get')) {
            // ส่งผลลัพธ์ข้อผิดพลาดกลับไปหน้าเดิม
            return redirect()->back()->with('error', 'Method not allowed');
        }

        // ตรวจสอบว่ามีไฟล์ที่อัปโหลดหรือไม่
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');

            // ตรวจสอบว่าไฟล์เป็นไฟล์ Excel หรือไม่ (ตรวจสอบด้วย MIME type)
            if ($file->getMimeType() == 'application/vnd.ms-excel' || $file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                // อ่านข้อมูลจากไฟล์ Excel
                $data = Excel::load($file)->get();

                // เพิ่มข้อมูลลงในฐานข้อมูล
                foreach ($data as $row) {
                    Asset::create([
                        'name' => $row->name,
                        'description' => $row->description,
                        // เพิ่มฟิลด์อื่นๆ ตามที่คุณมีในไฟล์ Excel
                    ]);
                }

                // ส่งกลับไปยังหน้าฟอร์มพร้อมกับข้อความแจ้งเตือน
                return redirect()->back()->with('success', 'เพิ่มข้อมูลครุภัณฑ์จาก Excel เรียบร้อยแล้ว');
            } else {
                // หากไฟล์ไม่ใช่ไฟล์ Excel
                return redirect()->back()->with('error', 'กรุณาอัปโหลดไฟล์ Excel เท่านั้น');
            }
        } else {
            // หากไม่มีไฟล์ที่อัปโหลด
            return redirect()->back()->with('error', 'กรุณาเลือกไฟล์ Excel ที่ต้องการอัปโหลด');
        }
    }
    
}


