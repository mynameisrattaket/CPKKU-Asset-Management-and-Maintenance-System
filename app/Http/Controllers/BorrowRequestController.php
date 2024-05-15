<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use Illuminate\Http\Request;

class BorrowRequestController extends Controller
{   

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_number' => 'required|string',
            'asset_name' => 'required|string',
            'borrower_name' => 'required|string',
            'borrower_surname' => 'required|string',
            'return_date' => 'required|date',
            
         
        ]);
    }

   


    public function borrowList()
    {
        $requests = BorrowRequest::all(); // ดึงข้อมูลคำร้องการยืมครุภัณฑ์ทั้งหมดจากฐานข้อมูล
        return view('borrowlist', compact('requests')); // ส่งข้อมูลไปยัง view ชื่อ borrowlist
    }


    
    public function index()
    {
        return view('storeborrowrequest');
    }

    

}
