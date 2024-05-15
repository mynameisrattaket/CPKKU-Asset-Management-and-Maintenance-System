<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
        $request->validate([
            'asset_name' => 'required',
            'symptom_detail' => 'required',
            'location' => 'required',
        ], [
            'asset_name.required' => 'กรุณาเลือกชื่อหรือประเภทของอุปกรณ์',
            'symptom_detail.required' => 'กรุณากรอกรายละเอียดอาการเสีย',
            'location.required' => 'กรุณาระบุสถานที่',
        ]);

        // Initialize $validatedData with required keys
        $validatedData = [
            'asset_name' => $request->input('asset_name'),
            'symptom_detail' => $request->input('symptom_detail'),
            'location' => $request->input('location'),
        ];

        // Check and assign 'other_asset_name' if filled
        if ($request->filled('other_asset_name')) {
            $validatedData['asset_name'] = $request->input('other_asset_name');
        }

        // Check and assign 'other_location' if filled
        if ($request->filled('other_location')) {
            $validatedData['location'] = $request->input('other_location');
        }

        // Check and assign 'asset_number' if filled
        if ($request->filled('asset_number')) {
            $validatedData['asset_number'] = $request->input('asset_number');
        }

        $request_time = Carbon::now('Asia/Bangkok')->locale('th_TH')->isoFormat('D MMMM YYYY, H:mm:ss');

        DB::table('request_detail')->insert([
            'asset_number' => $validatedData['asset_number'] ?? null,
            'asset_name' => $validatedData['asset_name'],
            'asset_symptom_detail' => $validatedData['symptom_detail'],
            'location' => $validatedData['location'],
            'request_time' => $request_time, // Store the current timestamp in Thai format
        ]);

        return redirect()->route('requestrepair')->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

}
