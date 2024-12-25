<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest; // Model สำหรับการยืมครุภัณฑ์
use App\Models\AssetMain; // Model สำหรับครุภัณฑ์

class BorrowRequestController extends Controller
{
    // ฟอร์มยืมครุภัณฑ์
    public function index()
    {
        $assets = AssetMain::all();  // ดึงข้อมูลครุภัณฑ์ทั้งหมดจากตาราง asset_main
        return view('storeborrowrequest', compact('assets')); // ส่งข้อมูลไปยัง view
    }

    // เก็บข้อมูลการยืมครุภัณฑ์
    public function storeborrowrequest(Request $request)
    {
        // ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'asset_id' => 'required|exists:asset_main,id',
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        // สร้างการยืมครุภัณฑ์ใหม่
        $borrowRequest = new BorrowRequest();
        $borrowRequest->asset_id = $request->asset_id;
        $borrowRequest->borrower_name = $request->borrower_name;
        $borrowRequest->borrow_date = $request->borrow_date;
        $borrowRequest->return_date = $request->return_date;
        $borrowRequest->status = 'pending';  // สถานะเริ่มต้น
        $borrowRequest->save();

        return redirect()->route('storeborrowrequest')->with('success', 'การยืมครุภัณฑ์ถูกบันทึกเรียบร้อย');
    }

    // แสดงรายการการยืมครุภัณฑ์
    public function borrowList()
    {
        $borrowRequests = BorrowRequest::with('asset')->get();  // ดึงข้อมูลการยืมทั้งหมด พร้อมข้อมูลครุภัณฑ์
        return view('borrowlist', compact('borrowRequests')); // ส่งข้อมูลไปยัง view
    }
}
