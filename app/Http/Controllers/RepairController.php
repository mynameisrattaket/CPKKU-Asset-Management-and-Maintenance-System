<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Repair;
use App\Models\Usermain; // Adjust namespace as per your User model
use App\Models\Karupan;
use App\Models\RequestRepair;
use Illuminate\Support\Facades\Mail;
use App\Mail\RepairRequestNotification;


class RepairController extends Controller
{
    public function dashboard()
    {
        // Fetch all repair requests with their statuses
        $repairs = DB::table('request_repair')
            ->join('request_detail', 'request_repair.request_repair_id', '=', 'request_detail.request_repair_id')
            ->select('request_repair.request_repair_id', 'request_detail.asset_name', 'request_detail.asset_symptom_detail', 'request_repair.repair_status_id', 'request_repair.updated_at')
            ->get();

        // Calculate counts for different statuses
        $reportCounts = [
            'total' => $repairs->count(),
            'in_progress' => $repairs->where('repair_status_id', 2)->count(),
            'waiting_for_parts' => $repairs->where('repair_status_id', 3)->count(),
            'completed' => $repairs->where('repair_status_id', 4)->count(),
            'cannot_be_repaired' => $repairs->where('repair_status_id', 5)->count(),
            'last_updated' => $repairs->max('updated_at') ? \Carbon\Carbon::parse($repairs->max('updated_at'))->diffForHumans() : 'ไม่มีการอัปเดต',
            'last_updated_in_progress' => $repairs->where('repair_status_id', 2)->max('updated_at') ? \Carbon\Carbon::parse($repairs->where('repair_status_id', 2)->max('updated_at'))->diffForHumans() : 'ไม่มีการอัปเดต',
            'last_updated_completed' => $repairs->where('repair_status_id', 4)->max('updated_at') ? \Carbon\Carbon::parse($repairs->where('repair_status_id', 4)->max('updated_at'))->diffForHumans() : 'ไม่มีการอัปเดต',
        ];

        // Adjust progress bar class and percentage based on status
        $repairs->transform(function ($repair) {
            switch ($repair->repair_status_id) {
                case 2:
                    $repair->progress_class = 'bg-warning'; // In Progress
                    $repair->progress_percentage = 50; // Example progress percentage
                    $repair->status_class = 'text-warning'; // Example status color
                    $repair->repair_status_name = 'กำลังดำเนินการ'; // Example status name
                    break;
                case 3:
                    $repair->progress_class = 'bg-primary'; // Waiting for Parts
                    $repair->progress_percentage = 75; // Example progress percentage
                    $repair->status_class = 'text-primary'; // Example status color
                    $repair->repair_status_name = 'รออะไหล่'; // Example status name
                    break;
                case 4:
                    $repair->progress_class = 'bg-success'; // Completed
                    $repair->progress_percentage = 100; // Example progress percentage
                    $repair->status_class = 'text-success'; // Example status color
                    $repair->repair_status_name = 'ดำเนินการเสร็จสิ้น'; // Example status name
                    break;
                case 5:
                    $repair->progress_class = 'bg-danger'; // Cannot be Repaired
                    $repair->progress_percentage = 0; // No progress
                    $repair->status_class = 'text-danger'; // Example status color
                    $repair->repair_status_name = 'ซ่อมไม่ได้'; // Example status name
                    break;
                default:
                    $repair->progress_class = 'bg-info'; // Default status
                    $repair->progress_percentage = 25; // Example progress percentage
                    $repair->status_class = 'text-info'; // Example status color
                    $repair->repair_status_name = 'รอดำเนินการ'; // Example status name
                    break;
            }
            return $repair;
        });

        return view('repair.repairmain', [
            'repairs' => $repairs,
            'reportCounts' => $reportCounts,
        ]);
    }



    public function index()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.user_id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.user_id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.user_first_name as requester_first_name',
                'requester.user_last_name as requester_last_name',
                'requester_type.user_type_name as requester_type_name',
                'technician.user_first_name as technician_first_name',
                'technician.user_last_name as technician_last_name',
                'technician_type.user_type_name as technician_type_name'
            )
            ->get();

        return view('repair.repairlist', compact('repairs'));
    }



    public function progress()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.user_id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.user_id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.user_first_name as requester_first_name',
                'requester.user_last_name as requester_last_name',
                'requester_type.user_type_name as requester_type_name',
                'technician.user_first_name as technician_first_name',
                'technician.user_last_name as technician_last_name',
                'technician_type.user_type_name as technician_type_name'
            )
            ->where(function ($query) {
                $query->where('repair_status.repair_status_id', 2) // กรองเฉพาะ repair_status_id = 2 (กำลังดำเนินการ)
                      ->orWhere('repair_status.repair_status_id', 3); // หรือ repair_status_id = 3 (รออะไหล่)
            })
            ->get();

        return view('repair.repairprogress', compact('repairs'));
    }

    public function done()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.user_id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.user_id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.user_first_name as requester_first_name',
                'requester.user_last_name as requester_last_name',
                'requester_type.user_type_name as requester_type_name',
                'technician.user_first_name as technician_first_name',
                'technician.user_last_name as technician_last_name',
                'technician_type.user_type_name as technician_type_name'
            )
            ->where('repair_status.repair_status_id', 4) // กรองเฉพาะ repair_status_id = 4
            ->get();

        return view('repair.repairdone', compact('repairs'));
    }

    public function cancle()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.user_id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.user_id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.user_first_name as requester_first_name',
                'requester.user_last_name as requester_last_name',
                'requester_type.user_type_name as requester_type_name',
                'technician.user_first_name as technician_first_name',
                'technician.user_last_name as technician_last_name',
                'technician_type.user_type_name as technician_type_name'
            )
            ->where('repair_status.repair_status_id', 5) // กรองเฉพาะ repair_status_id = 5
            ->get();

        return view('repair.repaircancle', compact('repairs'));
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
        $assets = Karupan::all(); // Fetch all assets from your 'asset_main' table

        // Fetch other necessary data
        $users = Usermain::all(); // Fetch all users from your 'user' table
        $technicians = Usermain::where('user_type_id', 2)->get();

        // Pass both variables to the view
        return view('repair.requestrepair', compact('assets', 'users', 'technicians'));
    }

    public function searchAssets(Request $request)
    {
        $keyword = $request->get('keyword');

        $assets = DB::table('durablearticles.asset_main')
                    ->where('asset_number', 'LIKE', "%{$keyword}%")
                    ->orWhere('asset_name', 'LIKE', "%{$keyword}%")
                    ->get(['asset_name', 'asset_number']);

        return response()->json($assets);
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
            'user_full_name' => 'required', // Add validation for user_full_name
            'technician_id' => 'required',
        ], [
            'asset_name.required' => 'กรุณาเลือกชื่อหรือประเภทของอุปกรณ์',
            'symptom_detail.required' => 'กรุณากรอกรายละเอียดอาการเสีย',
            'location.required' => 'กรุณาระบุสถานที่',
            'other_asset_name.required_if' => 'กรุณากรอกชื่อหรือประเภทของอุปกรณ์',
            'other_location.required_if' => 'กรุณากรอกสถานที่',
            'asset_image.*.image' => 'ไฟล์ต้องเป็นภาพ',
            'asset_image.*.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท jpeg, png, jpg, หรือ gif',
            'asset_image.*.max' => 'ขนาดของรูปภาพต้องไม่เกิน 5MB',
            'user_full_name.required' => 'กรุณาเลือกชื่อผู้แจ้ง',
            'technician_id.required' => 'กรุณาเลือกช่างที่รับผิดชอบงาน',
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
            'repair_status_id' => 1, // สมมติว่า 1 คือสถานะเริ่มต้นสำหรับการแจ้งใหม่
            'request_repair_at' => now(),
            'user_user_id' => $request->input('user_full_name'), // ใช้ค่า user_full_name ที่ได้รับจากฟอร์ม
            'technician_id' => $request->input('technician_id'),
        ]);

        DB::transaction(function () use ($request, $validatedData) {
            // Insert into request_repair table
            $requestRepairId = DB::table('request_repair')->insertGetId([
                'repair_status_id' => 1,
                'request_repair_at' => now(),
                'user_user_id' => $request->input('user_full_name'),
                'technician_id' => $request->input('technician_id'),
            ]);

            // Insert into request_detail table
            DB::table('request_detail')->insert([
                'asset_number' => $validatedData['asset_number'] ?? null,
                'asset_name' => $validatedData['asset_name'],
                'asset_symptom_detail' => $validatedData['symptom_detail'],
                'location' => $validatedData['location'],
                'request_repair_id' => $requestRepairId,
                'asset_image' => $validatedData['asset_image'] ?? null,
            ]);
        });



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

        // Fetch the reporter's and technician's emails
        $reporter = DB::table('user')->where('user_id', $request->input('user_full_name'))->first();
        $technician = DB::table('user')->where('user_id', $request->input('technician_id'))->first();

        // Prepare the repair details data
        $repairDetails = [
            'asset_name' => $validatedData['asset_name'],
            'symptom_detail' => $request->input('symptom_detail'),
            'location' => $validatedData['location'],
            'asset_number' => $validatedData['asset_number'] ?? null,
            'request_repair_at' => now(),
        ];


        // Send email notifications to both reporter and technician
        Mail::to($reporter->user_email)->queue(new RepairRequestNotification($repairDetails, $technician, $reporter));
        Mail::to($technician->user_email)->queue(new RepairRequestNotification($repairDetails, $technician, $reporter));

        // Redirect back to the request form with a success message and default input values
        return redirect()->route('requestrepair')->with('success', 'บันทึกข้อมูลสำเร็จ')->withInput($defaultValues);
    }


    public function search(Request $request)
    {
        // รับค่าการค้นหาจากฟอร์ม
        $searchrepair = $request->input('searchasset');
        $asset_number = $request->input('asset_number');
        $asset_symptom_detail = $request->input('asset_symptom_detail');
        $location = $request->input('location');
        $request_repair_note = $request->input('request_repair_note');

        // สร้าง query สำหรับค้นหาข้อมูล
        $query = DB::table('request_detail');

        if (!empty($searchrepair)) {
            $keywords = explode(' ', $searchrepair);
            foreach ($keywords as $keyword) {
                $query->where(function($query) use ($keyword) {
                    $query->where('asset_name', 'LIKE', "%$keyword%")
                          ->orWhere('asset_number', 'LIKE', "%$keyword%")
                          ->orWhere('asset_symptom_detail', 'LIKE', "%$keyword%")
                          ->orWhere('location', 'LIKE', "%$keyword%")
                          ->orWhere('request_repair_note', 'LIKE', "%$keyword%");
                });
            }
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
        // ดึงข้อมูลจากการค้นหา
        $search = $query->get();

        // ส่งข้อมูลไปยังหน้า view
        return view('repair.searchrepair', compact('search'));
    }

}
