<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use Illuminate\Http\Request;

class BorrowRequestController extends Controller
{
    public function store(Request $request)
    {
        return view('borrowlist');
        // Validate ข้อมูล
        $validatedData = $request->validate([
            'asset_number' => 'required|string',
            'asset_name' => 'required|string',
            'borrower_name' => 'required|string',
            'borrower_surname' => 'required|string',
            'return_date' => 'required|date',
         
        ]);

        // บันทึกข้อมูลลงในฐานข้อมูล
        BorrowRequest::create($validatedData);

        // ส่งกลับไปยังหน้าแบบฟอร์มพร้อมกับข้อความสำเร็จ
        return redirect()->back()->with('success', 'บันทึกคำร้องการยืมครุภัณฑ์เรียบร้อยแล้ว');
    }
    
    public function index()
    {
        return view('storeborrowrequest');
    }

    

}
