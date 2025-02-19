<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use App\Models\AssetMain;

class BorrowRequestController extends Controller
{
    // แสดงรายการคำร้องทั้งหมด พร้อมตัวกรองสถานะ
    public function index(Request $request)
{
    $assets = AssetMain::all(); // ดึงข้อมูลครุภัณฑ์ทั้งหมด

    $query = BorrowRequest::with('asset');

    // ตัวกรองข้อมูล
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $borrowRequests = $query->orderBy('borrow_date', 'desc')->get();

    return view('storeborrowrequest', compact('borrowRequests', 'assets')); // ส่งตัวแปร $assets ไปที่ View
}


    // บันทึกคำร้องยืมครุภัณฑ์
    public function storeborrowrequest()
{
    $assets = AssetMain::all(); // ดึงข้อมูลครุภัณฑ์ทั้งหมด
    return view('storeborrowrequest', compact('assets')); // ส่งตัวแปร assets ไปยัง View
}


    // แสดงรายการการยืมครุภัณฑ์
    public function borrowList()
    {
        $borrowRequests = BorrowRequest::with('asset')->get();
        return view('borrowlist', compact('borrowRequests'));
    }

    // แสดงประวัติการยืมครุภัณฑ์
    public function borrowHistory()
    {
        $borrowRequests = BorrowRequest::with('asset')->get();
        return view('borrowhistory', compact('borrowRequests'));
    }

    // แสดงรายการคำร้องรอดำเนินการ
    public function pendingBorrows()
    {
        $pendingBorrows = BorrowRequest::where('status', 'pending')->with('asset')->get();
        return view('borrowpending', compact('pendingBorrows'));
    }

    // อัปเดตสถานะคำร้อง
    public function updateBorrowStatus(Request $request, $id)
    {
        $borrow = BorrowRequest::findOrFail($id);

        // ตรวจสอบว่าสถานะที่ส่งมาต้องถูกต้อง
        $status = $request->input('borrow_status');
        if (!in_array($status, ['pending', 'approved', 'completed', 'rejected'])) {
            return redirect()->back()->withErrors(['error' => 'สถานะที่ส่งมาไม่ถูกต้อง']);
        }

        // อัปเดตสถานะ
        $borrow->status = $status;

        // ถ้าสถานะเป็น "อนุมัติ" ให้เปลี่ยนเป็น "เสร็จสิ้น"
        if ($status === 'approved') {
            $borrow->status = 'completed';
        }

        $borrow->save();
        return redirect()->route('borrowpending')->with('success', 'สถานะคำร้องได้รับการอัปเดตเรียบร้อยแล้ว');
    }

    // แสดงรายการคำร้องที่เสร็จสิ้น
    public function completedBorrows()
    {
        $completedBorrows = BorrowRequest::where('status', 'completed')->with('asset')->get();
        return view('borrowcompleted', compact('completedBorrows'));
    }

    // แสดงรายการคำร้องที่ถูกปฏิเสธ
    public function rejectedBorrows()
    {
        $rejectedBorrows = BorrowRequest::where('status', 'rejected')->with('asset')->get();
        return view('borrowrejected', compact('rejectedBorrows'));
    }

}

