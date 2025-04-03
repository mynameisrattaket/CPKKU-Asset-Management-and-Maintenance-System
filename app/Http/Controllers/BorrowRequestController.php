<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use App\Models\AssetMain;
use App\Exports\BorrowExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class BorrowRequestController extends Controller
{
    // แสดงรายการคำร้องทั้งหมด พร้อมตัวกรองสถานะ
    public function index(Request $request)
    {
        if (!Auth::check()) {
            // หากยังไม่ได้ล็อกอิน ส่งข้อความ "ไม่สามารถดูข้อมูลได้"
            return redirect()->route('login')->with('error', 'กรุณาล็อกอินเพื่อเข้าถึงข้อมูล');
        }

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

        // 🔍 ค้นหาด้วยชื่อหรือหมายเลขครุภัณฑ์
        if ($request->filled('searchasset')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('asset_name', 'like', '%' . $request->searchasset . '%')
                  ->orWhere('asset_number', 'like', '%' . $request->searchasset . '%');
            });
        }

        // 🔍 ค้นหาด้วยชื่อผู้ยืม
        if ($request->filled('borrower_name')) {
            $query->where('borrower_name', 'like', '%' . $request->borrower_name . '%');
        }

        // 🔍 ค้นหาตามวันที่ยืม
        if ($request->filled('borrow_date')) {
            $query->whereDate('borrow_date', $request->borrow_date);
        }

        // 🔍 ค้นหาตามวันที่คืน
        if ($request->filled('return_date')) {
            $query->whereDate('return_date', $request->return_date);
        }

        // 🔍 ค้นหาตามสถานะ
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
        $request->validate([
            'asset_id' => 'required',
            'borrower_name' => 'required',
            'borrow_date' => 'required|date_format:d/m/Y',
            'return_date' => 'required|date_format:d/m/Y|after:borrow_date',
            'location' => 'required',
        ]);

        BorrowRequest::create([
            'asset_id' => $request->asset_id,
            'borrower_name' => $request->borrower_name,
            'borrow_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->borrow_date)->format('Y-m-d'),
            'return_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->return_date)->format('Y-m-d'),
            'location' => $request->location,
            'note' => $request->note,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'บันทึกการยืมสำเร็จ!');
    }


    public function borrowHistory(Request $request)
{
    // ตรวจสอบว่าผู้ใช้ได้ล็อกอินหรือไม่
    if (!Auth::check()) {
        // หากยังไม่ได้ล็อกอิน ส่งข้อความ "ไม่สามารถดูข้อมูลได้"
        return redirect()->route('login')->with('error', 'กรุณาล็อกอินเพื่อเข้าถึงข้อมูล');
    }

    // เริ่มต้น query สำหรับดึงข้อมูลจาก borrow_requests
    $query = BorrowRequest::with('asset'); // ดึงข้อมูลเชื่อมโยงกับตาราง 'asset'

    $user = Auth::user();  // ดึงข้อมูลผู้ใช้ที่ล็อกอิน
    $role = $user->role;   // ตรวจสอบบทบาทของผู้ใช้ที่ล็อกอิน
    $user_type_id = $user->user_type_id; // หรือใช้ user_type_id ในการตรวจสอบ

    // ตรวจสอบว่าเป็นแอดมินหรือไม่
    if ($role == 'admin' || $user_type_id == 6) {  // กรณีที่แอดมินมี user_type_id = 6
        // หากเป็นแอดมิน ให้แสดงคำขอยืมทั้งหมด (ไม่กรองตาม borrower_name)
    } else {
        // หากไม่ใช่แอดมิน กรองข้อมูลตาม borrower_name ของผู้ใช้ที่ล็อกอิน
        $query->where('borrower_name', $user->name); // กรองเฉพาะคำขอยืมที่มี borrower_name ตรงกับชื่อผู้ใช้ที่ล็อกอิน
    }

    // 🔍 กรองตามหมายเลขครุภัณฑ์ หรือ ชื่อครุภัณฑ์
    if ($request->filled('searchasset')) {
        $query->whereHas('asset', function ($q) use ($request) {
            $q->where('asset_number', 'like', "%{$request->searchasset}%")
              ->orWhere('asset_name', 'like', "%{$request->searchasset}%");
        });
    }

    // 👤 กรองตามชื่อผู้ยืม (ในที่นี้จะเป็น $user->name)
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

    // ส่งข้อมูลไปที่ view
    return view('borrow.borrowhistory', compact('borrowRequests'));
}


    // อนุมัติคำร้อง
    public function approve($id)
    {
        $borrow = BorrowRequest::findOrFail($id);
        $borrow->status = 'approved';
        $borrow->save();

        return back()->with('success', ' คำร้องได้รับการอนุมัติแล้ว!✅');
    }

    // ปฏิเสธคำร้อง
    public function reject($id)
    {
        $borrow = BorrowRequest::findOrFail($id);
        $borrow->status = 'rejected';
        $borrow->save();

        return back()->with('error', 'คำร้องถูกปฏิเสธแล้ว!❌ ');
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

    public function update(Request $request, $id)
{
    $request->validate([
        'borrower_name' => 'required|string|max:255',
        'borrow_date' => 'required|date',
        'return_date' => 'nullable|date|after_or_equal:borrow_date',
        'location' => 'required|string|max:255',
        'note' => 'nullable|string',
    ]);

    $borrow = BorrowRequest::findOrFail($id);
    $borrow->update($request->only(['borrower_name', 'borrow_date', 'return_date', 'location', 'note']));

    return redirect()->route('borrowlist')->with('success', '✅ แก้ไขคำร้องสำเร็จแล้ว');
}

}
