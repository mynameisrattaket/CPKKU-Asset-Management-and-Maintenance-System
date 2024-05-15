<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepairController extends Controller
{
    public function index()
    {

        $request = DB::table('request_detail')->get();
        return view('repairlist', compact('request'));
    }

    public function search(Request $input){

        $search = $input->input('search');

        $request = DB::table('request_detail')->where('asset_name', 'LIKE', "%$search%")
            ->orWhere('asset_symptom_detail', 'LIKE', "%$search%")
            ->orWhere('asset_number', 'LIKE', "%$search%")
            ->orWhere('asset_symptom_detail', 'LIKE', "%$search%")
            ->orWhere('location', 'LIKE', "%$search%")
            ->orWhere('request_time', 'LIKE', "%$search%")
            ->get();

        return view("repairlist", compact('request'));

    }

    public function showAddForm()
    {
        return view('requestrepair');
    }

    public function storeRepairRequest(Request $request)
    {
        $validatedData = $request->validate([
            'asset_number' => 'nullable', // อนุญาตให้หมายเลขครุภัณฑ์เป็นค่าว่างได้
            'asset_name' => 'required',
            'symptom_detail' => 'required',
            'location' => 'required',
            'other_asset_name' => 'nullable|string',
            'other_location' => 'nullable|string',
        ]);

        // ใช้ค่า 'other_asset_name' หากมีการกรอกข้อมูล
        if ($request->filled('other_asset_name')) {
            $validatedData['asset_name'] = $request->input('other_asset_name');
        }

        // ใช้ค่า 'other_location' หากมีการกรอกข้อมูล
        if ($request->filled('other_location')) {
            $validatedData['location'] = $request->input('other_location');
        }

        DB::table('request_detail')->insert([
            'asset_number' => $validatedData['asset_number'],
            'asset_name' => $validatedData['asset_name'],
            'asset_symptom_detail' => $validatedData['symptom_detail'],
            'location' => $validatedData['location'],
            'request_time' => DB::raw('NOW()'), // บันทึกเวลา ณ ปัจจุบัน
        ]);

        return redirect()->route('requestrepair')->with('success', 'เพิ่มข้อมูลการแจ้งซ่อมสำเร็จ');
    }


}
