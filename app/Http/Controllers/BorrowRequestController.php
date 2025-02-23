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
        $assets = AssetMain::all();
        $query = BorrowRequest::with('asset');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowRequests = $query->orderBy('borrow_date', 'desc')->get();

        return view('storeborrowrequest', compact('borrowRequests', 'assets'));
    }

    public function export()
    {
        return Excel::download(new BorrowExport, 'borrow_requests.xlsx');
    }

    // แสดงรายการการยืมครุภัณฑ์
    public function borrowList(Request $request)
    {
        $statusFilter = $request->get('status', 'all');

        $countPending = BorrowRequest::where('status', 'pending')->count();
        $countApproved = BorrowRequest::where('status', 'approved')->count();
        $countRejected = BorrowRequest::where('status', 'rejected')->count();
        $countCompleted = BorrowRequest::where('status', 'completed')->count();

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

    // ✅ เพิ่มเมธอด borrowHistory() เพื่อแสดงประวัติคำร้อง
    public function borrowHistory()
    {
        $borrowRequests = BorrowRequest::with('asset')->get();
        return view('borrowhistory', compact('borrowRequests'));
    }


    // อนุมัติคำร้อง
    public function approve($id)
    {
        $borrow = BorrowRequest::findOrFail($id);
        $borrow->status = 'approved';
        $borrow->save();

        return back()->with('success', '✅ คำร้องได้รับการอนุมัติแล้ว!');
    }

    // ปฏิเสธคำร้อง
    public function reject($id)
    {
        $borrow = BorrowRequest::findOrFail($id);
        $borrow->status = 'rejected';
        $borrow->save();

        return back()->with('error', '❌ คำร้องถูกปฏิเสธแล้ว!');
    }

    // ✅ **แก้ไขคำร้อง**
    public function edit($id)
{
    $borrow = BorrowRequest::findOrFail($id);
    $assets = AssetMain::all();

    return view('borrow.edit', compact('borrow', 'assets'));
}


    // ✅ **อัปเดตคำร้อง**
    public function update(Request $request, $id)
{
    $borrow = BorrowRequest::findOrFail($id);

    $validated = $request->validate([
        'borrower_name' => 'required|string|max:255',
        'borrow_date' => 'required|date',
        'return_date' => 'required|date|after:borrow_date',
        'location' => 'required|string',
        'note' => 'nullable|string',
    ]);

    $borrow->update($validated);

    return redirect()->route('borrowlist')->with('success', '✅ อัปเดตคำร้องสำเร็จ!');
}

    // ✅ ลบคำร้องขอ (เฉพาะสถานะ Pending เท่านั้น)
    public function destroy($id)
{
    $borrow = BorrowRequest::findOrFail($id);
    $borrow->delete();

    return redirect()->route('borrowlist')->with('success', '🗑️ คำร้องถูกลบเรียบร้อย!');
}


}
