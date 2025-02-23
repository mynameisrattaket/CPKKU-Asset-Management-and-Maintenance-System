<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use App\Models\AssetMain;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BorrowExport;

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

    public function export()
    {
        return Excel::download(new BorrowExport, 'borrow_requests.xlsx');
    }

    // บันทึกคำร้องยืมครุภัณฑ์
    public function storeborrowrequest()
{
    $assets = AssetMain::all(); // ดึงข้อมูลครุภัณฑ์ทั้งหมด
    return view('storeborrowrequest', compact('assets')); // ส่งตัวแปร assets ไปที่ View
}


    // แสดงรายการการยืมครุภัณฑ์
    public function borrowList(Request $request)
{
    $statusFilter = $request->get('status', 'all');

    // ดึงข้อมูลและคำนวณจำนวนแต่ละสถานะ
    $countPending = BorrowRequest::where('status', 'pending')->count();
    $countApproved = BorrowRequest::where('status', 'approved')->count();
    $countRejected = BorrowRequest::where('status', 'rejected')->count();
    $countCompleted = BorrowRequest::where('status', 'completed')->count();

    // Query ข้อมูลการยืม
    $query = BorrowRequest::with('asset');

    if ($statusFilter !== 'all') {
        $query->where('status', $statusFilter);
    }

    $borrowRequests = $query->get();

    return view('borrowlist', compact(
        'borrowRequests', 'statusFilter', 
        'countPending', 'countApproved', 'countRejected', 'countCompleted'
    ));
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

    public function store(Request $request)
{
    $validated = $request->validate([
        'asset_id' => 'required|exists:asset_main,id', // ต้องมีและต้องตรงกับฐานข้อมูล
        'borrower_name' => 'required|string|max:255',
        'borrow_date' => 'required|date',
        'return_date' => 'required|date|after:borrow_date',
        'location' => 'required|string',
        'note' => 'nullable|string',
    ]);

    // ตรวจสอบค่าที่รับเข้ามา
    if (!$request->has('asset_id')) {
        return back()->withErrors(['asset_id' => 'กรุณาเลือกครุภัณฑ์']);
    }

    BorrowRequest::create([
        'asset_id' => $validated['asset_id'],
        'borrower_name' => $validated['borrower_name'],
        'borrow_date' => $validated['borrow_date'],
        'return_date' => $validated['return_date'],
        'status' => 'pending', // ค่าเริ่มต้น
        'location' => $validated['location'],
        'note' => $validated['note'] ?? null,
    ]);

    return redirect()->route('borrowlist')->with('success', 'บันทึกคำขอยืมสำเร็จ!');
}

public function approve($id)
{
    $borrow = BorrowRequest::findOrFail($id);
    $borrow->status = 'approved';
    $borrow->save();

    return response()->json(['message' => 'คำร้องได้รับการอนุมัติแล้ว!']);
}

public function reject($id)
{
    $borrow = BorrowRequest::findOrFail($id);
    $borrow->status = 'rejected';
    $borrow->save();

    return response()->json(['message' => 'คำร้องถูกปฏิเสธแล้ว!']);
}

public function details($id)
{
    $borrow = BorrowRequest::with('asset')->findOrFail($id);
    return view('borrow.details', compact('borrow'));
}
public function edit($id)
{
    $borrow = BorrowRequest::findOrFail($id);
    return view('borrow.edit', compact('borrow'));
}


}

