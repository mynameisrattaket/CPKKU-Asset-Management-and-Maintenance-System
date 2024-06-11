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
            ->select('request_detail.*', 'request_repair.request_repair_at','request_repair.update_status_at', 'repair_status.repair_status_name', 'repair_status.repair_status_id')
            ->get();



        return view('repairlist', compact('repairs'));
    }

    public function progress()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->select('request_detail.*', 'request_repair.request_repair_at','request_repair.update_status_at', 'repair_status.repair_status_name', 'repair_status.repair_status_id')
            ->where(function ($query) {
                $query->where('repair_status.repair_status_id', 2) // กรองเฉพาะ repair_status_id = 2 (กำลังดำเนินการ)
                      ->orWhere('repair_status.repair_status_id', 3); // หรือ repair_status_id = 3 (รออะไหล่)
            })
            ->get();

        return view('repairprogress', compact('repairs'));
    }

    public function done()
    {
    $repairs = DB::table('request_detail')
        ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
        ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
        ->select('request_detail.*', 'request_repair.request_repair_at','request_repair.update_status_at', 'repair_status.repair_status_name', 'repair_status.repair_status_id')
        ->where('repair_status.repair_status_id', 4) // กรองเฉพาะ repair_status_id = 4
        ->get();

    return view('repairdone', compact('repairs'));
    }

    public function cancle()
    {
    $repairs = DB::table('request_detail')
        ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
        ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
        ->select('request_detail.*', 'request_repair.request_repair_at','request_repair.update_status_at', 'repair_status.repair_status_name', 'repair_status.repair_status_id')
        ->where('repair_status.repair_status_id', 5) // กรองเฉพาะ repair_status_id = 5
        ->get();

    return view('repaircancle', compact('repairs'));
    }






    public function updateRepairStatus(Request $request, $id)
    {
        $request->validate([
            'repair_status_id' => 'required|integer|exists:repair_status,repair_status_id',
            'request_repair_note' => 'nullable|string|max:255',
        ]);

        $requestRepairId = DB::table('request_detail')
            ->where('request_detail_id', $id)
            ->value('request_repair_id');

        if ($requestRepairId) {
            DB::table('request_repair')
                ->where('request_repair_id', $requestRepairId)
                ->update(['repair_status_id' => $request->repair_status_id]);

            DB::table('request_detail')
                ->where('request_detail_id', $id)
                ->update(['request_repair_note' => $request->request_repair_note]);

            return redirect()->route('repairlist')->with('success', 'สถานะการซ่อมถูกอัปเดตเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบรายการซ่อมที่เกี่ยวข้อง');
        }
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
            'other_asset_name' => 'required_if:asset_name,Other',
            'other_location' => 'required_if:location,other',
            'asset_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Set max size to 5MB
        ], [
            'asset_name.required' => 'กรุณาเลือกชื่อหรือประเภทของอุปกรณ์',
            'symptom_detail.required' => 'กรุณากรอกรายละเอียดอาการเสีย',
            'location.required' => 'กรุณาระบุสถานที่',
            'other_asset_name.required_if' => 'กรุณากรอกชื่อหรือประเภทของอุปกรณ์',
            'other_location.required_if' => 'กรุณากรอกสถานที่',
            'asset_image.*.image' => 'ไฟล์ต้องเป็นภาพ',
            'asset_image.*.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท jpeg, png, jpg, หรือ gif',
            'asset_image.*.max' => 'ขนาดของรูปภาพต้องไม่เกิน 5MB',
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

        // Handle the image upload if provided
        if ($request->hasFile('asset_image')) {
            $images = $request->file('asset_image');
            $imageNames = [];

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $imageNames[] = $imageName;
            }

            // Ensure the image names are properly encoded in JSON format
            $validatedData['asset_image'] = json_encode($imageNames);
        }

        // Set the current timestamp in MySQL datetime format
        $request_time = Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s');

        // Insert into request_repair table first
        $requestRepairId = DB::table('request_repair')->insertGetId([
            'repair_status_id' => 1, // Assuming 1 is the default status for new requests
            'request_repair_at' => $request_time,
        ]);

        // Insert the data into the 'request_detail' table with the request_repair_id
        DB::table('request_detail')->insert([
            'asset_number' => $validatedData['asset_number'] ?? null,
            'asset_name' => $validatedData['asset_name'],
            'asset_symptom_detail' => $validatedData['symptom_detail'],
            'location' => $validatedData['location'],
            'request_repair_id' => $requestRepairId,
            'asset_image' => $validatedData['asset_image'] ?? null, // Save the image names if exist
        ]);

        // Clear input data if successfully saved
        $request->session()->forget('clear_input');

        // Set default values for input fields
        $defaultValues = [
            'asset_name' => '',
            'symptom_detail' => '',
            'location' => '',
            'other_asset_name' => '',
            'other_location' => '',
            'asset_number' => '',
            'asset_image' => '',
        ];

        // Redirect back to the request form with a success message and default input values
        return redirect()->route('requestrepair')->with('success', 'บันทึกข้อมูลสำเร็จ')->withInput($defaultValues);
    }








    public function search(Request $request)
    {
    // รับค่าการค้นหาจากฟอร์ม
    $searchrepair = $request->input('searchrepair');
    $asset_number = $request->input('asset_number');
    $asset_price = $request->input('asset_symptom_detail');
    $asset_status_id = $request->input('location');
    $asset_comment = $request->input('request_repair_note');

    // แยกคำค้นหาออกเป็นคำสั้นๆ
    $keywords = explode(' ', $searchrepair);


    // ค้นหาข้อมูลครุภัณฑ์ที่ตรงกับการค้นหา
     $query = DB::table('request_detail');
    foreach ($keywords as $keyword) {
        $query->where(function($query) use ($keyword) {
            $query->where('asset_name', 'LIKE', "%$keyword%")
                  ->orWhere('asset_number', 'LIKE', "%$keyword%")
                  ->orWhere('asset_symptom_detail', 'LIKE', "%$keyword%")
                  ->orWhere('location', 'LIKE', "%$keyword%")
                  ->orWhere('request_repair_note', 'LIKE', "%$keyword%");
        });
    }
    if (!empty($asset_number)) {
        $query->where('asset_number', 'LIKE', "%$asset_number%");
    }
    if (!empty($asset_symptom_detail)) {
        $query->where('asset_symptom_detail', 'LIKE', "%$asset_symptom_detail%");
    }
    if (!empty($location)) {
        $query->where('location', 'LIKE', "%$location%");
    }
    if (!empty($request_repair_note)) {
        $query->where('request_repair_note', 'LIKE', "%$request_repair_note%");
    }

    $search = $query->get();

    // ส่งข้อมูลไปยังหน้า view
    return view('searchrepair', compact('search'));
    }

}
