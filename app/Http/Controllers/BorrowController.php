<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{

    public function index()
    {
        $borrowRequests = DB::table('borrow_requests')->get();
        return view('storeborrowrequest', compact('borrowRequests'));
    }

    public function storeBorrowRequest(Request $request)
    {
        $validatedData = $request->validate([
            'asset_number' => 'required',
            'asset_name' => 'required',
            'borrower_name' => 'required',
            'borrower_surname' => 'required',
            'return_date' => 'required|date',
        ]);

        DB::table('borrow_requests')->insert([
            'asset_number' => $validatedData['asset_number'],
            'asset_name' => $validatedData['asset_name'],
            'borrower_name' => $validatedData['borrower_name'],
            'borrower_surname' => $validatedData['borrower_surname'],
            'return_date' => $validatedData['return_date'],
        ]);

        $borrowRequests = DB::table('borrow_requests')->get();

        return view('borrowrequest', compact('borrowRequests'))->with('success', 'บันทึกคำร้องการยืมครุภัณฑ์สำเร็จ');
    }
    
}
