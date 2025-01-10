<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use App\Models\AssetMain;

class BorrowRequestController extends Controller
{
    public function index()
{
    $assets = AssetMain::all(); // ดึงข้อมูลครุภัณฑ์ทั้งหมด
    return view('storeborrowrequest', compact('assets')); // ส่งข้อมูลไปยัง View
}

    // บันทึกข้อมูลการยืมครุภัณฑ์
    public function storeborrowrequest(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:asset_main,asset_id', // ตรวจสอบว่าครุภัณฑ์มีอยู่จริง
            'borrower_name' => 'required|string|max:255', // ชื่อผู้ยืมต้องเป็น string
            'borrow_date' => 'required|date|before_or_equal:today', // วันที่ยืมต้องไม่เกินวันนี้
            'return_date' => 'required|date|after_or_equal:borrow_date', // วันที่คืนต้องไม่น้อยกว่าวันที่ยืม
        ]);

        // สร้างคำร้องยืมครุภัณฑ์ใหม่
        BorrowRequest::create([
            'asset_id' => $validated['asset_id'],
            'borrower_name' => $validated['borrower_name'],
            'borrow_date' => $validated['borrow_date'],
            'return_date' => $validated['return_date'],
            'status' => 'pending',  // กำหนดสถานะเป็นรออนุมัติ
        ]);

        return redirect()->route('storeborrowrequest')->with('success', 'บันทึกคำร้องยืมครุภัณฑ์สำเร็จ!');
    }



    // แสดงรายการการยืมครุภัณฑ์
    public function borrowList()
    {
        $borrowRequests = BorrowRequest::with('asset')->get(); // ดึงข้อมูลพร้อมความสัมพันธ์
        return view('borrowlist', compact('borrowRequests'));
    }

    // แสดงประวัติการยืมครุภัณฑ์
    public function borrowHistory()
    {
        $assets = AssetMain::all(); // ดึงข้อมูลทั้งหมด
        return view('borrowhistory', compact('assets')); // ส่งข้อมูลไปยัง View
    }

    public function searchAsset(Request $request)
{
    $query = AssetMain::query();

    if ($request->filled('searchasset')) {
        $query->where('asset_name', 'like', '%' . $request->searchasset . '%');
    }

    if ($request->filled('asset_number')) {
        $query->where('asset_number', 'like', '%' . $request->asset_number . '%');
    }

    if ($request->filled('location')) {
        $query->where('asset_location', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('asset_comment')) {
        $query->where('asset_comment', 'like', '%' . $request->asset_comment . '%');
    }

    $assets = $query->get();

    return view('searchasset', compact('assets'));
}

}
