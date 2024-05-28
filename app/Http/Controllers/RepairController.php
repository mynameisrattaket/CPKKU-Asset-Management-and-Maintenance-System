<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Repair;

class RepairController extends Controller
{
    public function index()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->select('request_detail.*', 'request_repair.request_repair_at', 'repair_status.repair_status_name', 'repair_status.repair_status_id')
            ->get();

        return view('repairlist', compact('repairs'));
    }

    public function updateRepairStatus(Request $request, $id)
    {
        $request->validate([
            'repair_status_id' => 'required|integer|exists:repair_status,repair_status_id',
        ]);

        $requestRepairId = DB::table('request_detail')
            ->where('request_detail_id', $id)
            ->value('request_repair_id');

        DB::table('request_repair')
            ->where('request_repair_id', $requestRepairId)
            ->update(['repair_status_id' => $request->repair_status_id]);

        return redirect()->route('repairlist')->with('success', 'สถานะการซ่อมถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function showAddForm()
    {
        return view('requestrepair');
    }

    public function storeRepairRequest(Request $request)
    {
        // Validate the request data with custom error messages
        $request->validate([
            'asset_name' => 'required',
            'symptom_detail' => 'required',
            'location' => 'required',
            'user_first_name' => 'required',
            'other_asset_name' => 'required_if:asset_name,Other',
            'other_location' => 'required_if:location,other',
        ], [
            'asset_name.required' => 'กรุณาเลือกชื่อหรือประเภทของอุปกรณ์',
            'symptom_detail.required' => 'กรุณากรอกรายละเอียดอาการเสีย',
            'location.required' => 'กรุณาระบุสถานที่',
            'user_first_name.required' => 'กรุณาเลือกช่างที่รับผิดชอบงาน',
            'other_asset_name.required_if' => 'กรุณากรอกชื่อหรือประเภทของอุปกรณ์',
            'other_location.required_if' => 'กรุณากรอกสถานที่',
        ]);

        // Initialize $validatedData with required keys
        $validatedData = [
            'asset_name' => $request->input('asset_name'),
            'symptom_detail' => $request->input('symptom_detail'),
            'location' => $request->input('location'),
            'user_first_name' => $request->input('user_first_name'),
            'request_user_id' => $request->input('request_user_id'),
            'request_user_type_id' => $request->input('request_user_type_id'),
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

        if ($request->filled('user_first_name')) {
            $validatedData['user_first_name'] = $request->input('user_first_name');
        }

        // Set the current timestamp in Thai format
        $request_time = Carbon::now('Asia/Bangkok')->locale('th_TH')->isoFormat('D MMMM YYYY, H:mm:ss');

        // Insert the data into the 'request_detail' table
        DB::table('request_detail')->insert([
            'asset_number' => $validatedData['asset_number'] ?? null,
            'asset_name' => $validatedData['asset_name'],
            'asset_symptom_detail' => $validatedData['symptom_detail'],
            'location' => $validatedData['location'],
            'user_first_name' => $validatedData['user_first_name'],
            'request_time' => $request_time, // Store the current timestamp in Thai format
            'request_user_id' => $validatedData['request_user_id'],
            'request_user_type_id' => $validatedData['request_user_type_id'],
        ]);

        // Clear input data if successfully saved
        $request->session()->forget('clear_input');

        // Set default values for input fields
        $defaultValues = [
            'asset_name' => '',
            'symptom_detail' => '',
            'location' => '',
            'user_first_name' => '',
            'other_asset_name' => '',
            'other_location' => '',
            'asset_number' => '',
            'request_user_id' => '',
            'request_user_type_id' => '',
        ];

        // Redirect back to the request form with a success message and default input values
        return redirect()->route('requestrepair')->with('success', 'บันทึกข้อมูลสำเร็จ')->withInput($defaultValues);
    }






}
