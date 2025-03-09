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

        return view('borrow.storeborrowrequest', compact('borrowRequests', 'assets'));
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

        return view('borrow.borrowlist', compact(
            'borrowRequests', 'statusFilter',
            'countPending', 'countApproved', 'countRejected', 'countCompleted'
        ));
    }

    // ✅ บันทึกคำขอยืมครุภัณฑ์
    public function store(Request $request)
    {
        // ✅ ตรวจสอบ Validation
        $validated = $request->validate([
            'asset_id' => 'required|exists:asset_main,asset_id',
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date_format:d/m/Y',
            'return_date' => 'required|date_format:d/m/Y|after:borrow_date',
            'location' => 'required|string',
            'note' => 'nullable|string',
        ]);

        // ✅ แปลงรูปแบบวันที่จาก "DD/MM/YYYY" เป็น "YYYY-MM-DD"
        $borrow_date = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['borrow_date'])->format('Y-m-d');
        $return_date = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['return_date'])->format('Y-m-d');

        // ✅ บันทึกข้อมูลลงฐานข้อมูล
        BorrowRequest::create([
            'asset_id' => $validated['asset_id'],
            'borrower_name' => $validated['borrower_name'],
            'borrow_date' => $borrow_date,  // 🔹 เปลี่ยนเป็น YYYY-MM-DD
            'return_date' => $return_date,  // 🔹 เปลี่ยนเป็น YYYY-MM-DD
            'location' => $validated['location'],
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('borrowhistory')->with('success', '✅ บันทึกคำขอยืมสำเร็จ!');
    }

    public function borrowHistory(Request $request)
    {
        $query = BorrowRequest::with('asset');

        // 🔍 กรองตามหมายเลขครุภัณฑ์ หรือ ชื่อครุภัณฑ์
        if ($request->filled('searchasset')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('asset_number', 'like', "%{$request->searchasset}%")
                ->orWhere('asset_name', 'like', "%{$request->searchasset}%");
            });
        }

        // 👤 กรองตามชื่อผู้ยืม
        if ($request->filled('borrower_name')) {
            $query->where('borrower_name', 'like', "%{$request->borrower_name}%");
        }

        // 📅 กรองตามวันที่ยืม
        if ($request->filled('borrow_date')) {
            $query->whereDate('borrow_date', $request->borrow_date);
        }

        // 📅 กรองตามวันที่คืน
        if ($request->filled('return_date')) {
            $query->whereDate('return_date', $request->return_date);
        }

        // ⏳ เรียงลำดับตาม ID จากน้อยไปมาก (asc) หรือจากมากไปน้อย (desc)
        $borrowRequests = $query->orderBy('id', 'asc')->get();  // เรียงตาม ID

        return view('borrow.borrowhistory', compact('borrowRequests'));
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

    // ✅ ลบคำร้องขอ (เฉพาะสถานะ Pending เท่านั้น)
     public function destroy($id)
    {
        $borrow = BorrowRequest::findOrFail($id);
        $borrow->delete();

        return redirect()->route('borrowlist')->with('success', '🗑️ คำร้องถูกลบเรียบร้อย!');
    }

    // ✅ ฟังก์ชันทำรายการคืนครุภัณฑ์
    public function markAsCompleted($id)
    {
        // 🔍 ดึงข้อมูลคำร้องจากฐานข้อมูล
        $borrow = BorrowRequest::findOrFail($id);

        // ❌ ป้องกันการคืน หากสถานะไม่ใช่ "อนุมัติ"
        if ($borrow->status !== 'approved') {
            return back()->with('error', '❌ ไม่สามารถคืนครุภัณฑ์ได้ เพราะสถานะไม่ถูกต้อง!');
        }

        // ✅ เปลี่ยนสถานะเป็น "คืนแล้ว" และกำหนดวันที่คืน
        $borrow->status = 'completed';
        $borrow->return_date = now(); // บันทึกวันที่คืนเป็นวันปัจจุบัน
        $borrow->save();

        return back()->with('success', '✅ ทำรายการคืนสำเร็จ!');
    }

    public function export()
    {
        return Excel::download(new BorrowExport, 'borrow_requests.xlsx');
    }
}
