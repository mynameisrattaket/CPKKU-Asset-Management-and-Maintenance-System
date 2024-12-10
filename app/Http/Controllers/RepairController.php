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
use Illuminate\Support\Facades\Auth; // เพิ่มบรรทัดนี้
use App\Mail\RepairStatusNotification;
use App\Mail\RepairStatusUpdateNotification;


class RepairController extends Controller
{
    public function dashboard()
    {
        // Fetch all repair requests with their statuses
        $repairs = DB::table('request_repair')
            ->join('request_detail', 'request_repair.request_repair_id', '=', 'request_detail.request_repair_id')
            ->select('request_repair.request_repair_id', 'request_detail.asset_name', 'request_detail.asset_symptom_detail', 'request_repair.repair_status_id', 'request_repair.updated_at', 'request_detail.repair_costs')
            ->get();

        // Calculate counts for different statuses
        $reportCounts = [
            'total' => $repairs->count(),
            'in_progress' => $repairs->whereIn('repair_status_id', [2, 3])->count(), // รวมกำลังดำเนินการและรออะไหล่
            'completed' => $repairs->where('repair_status_id', 4)->count(),
            'cannot_be_repaired' => $repairs->where('repair_status_id', 5)->count(),
            'last_updated' => $repairs->max('updated_at') ? \Carbon\Carbon::parse($repairs->max('updated_at'))->diffForHumans() : 'ไม่มีการอัปเดต',
            'last_updated_in_progress' => $repairs->whereIn('repair_status_id', [2, 3])->max('updated_at') ? \Carbon\Carbon::parse($repairs->whereIn('repair_status_id', [2, 3])->max('updated_at'))->diffForHumans() : 'ไม่มีการอัปเดต', // รวมการอัปเดตล่าสุดของทั้งสองสถานะ
            'last_updated_completed' => $repairs->where('repair_status_id', 4)->max('updated_at') ? \Carbon\Carbon::parse($repairs->where('repair_status_id', 4)->max('updated_at'))->diffForHumans() : 'ไม่มีการอัปเดต',
        ];

        // Calculate costs and counts by year, including completed repairs in that year
        $costsByYear = DB::table('request_repair')
            ->selectRaw('YEAR(request_repair.request_repair_at) as year,
                        COUNT(DISTINCT request_repair.request_repair_id) as total_reports,
                        COUNT(DISTINCT CASE WHEN request_repair.repair_status_id = 4 THEN request_repair.request_repair_id END) as completed_repairs,
                        SUM(request_detail.repair_costs) as total_cost')
            ->join('request_detail', 'request_repair.request_repair_id', '=', 'request_detail.request_repair_id')
            ->groupBy(DB::raw('YEAR(request_repair.request_repair_at)'))
            ->orderBy('year', 'desc')
            ->get();

        // Fetch total repair costs across all years
        $totalCost = DB::table('request_detail')->sum('repair_costs');

        // Fetch technician overview data
        $technicianPerformance = DB::table('request_repair as rr')
            ->leftJoin('request_detail as rd', 'rr.request_repair_id', '=', 'rd.request_repair_id')
            ->join('user as u', 'rr.technician_id', '=', 'u.id')
            ->join('user_type as ut', 'u.user_type_id', '=', 'ut.user_type_id')
            ->select(
                'rr.technician_id',
                DB::raw('u.name as technician_name'),
                DB::raw('COUNT(*) as total_tasks'),
                DB::raw('SUM(CASE WHEN rr.repair_status_id = 1 THEN 1 ELSE 0 END) as pending_tasks'),
                DB::raw('SUM(CASE WHEN rr.repair_status_id = 2 THEN 1 ELSE 0 END) as in_progress_tasks'),
                DB::raw('SUM(CASE WHEN rr.repair_status_id = 3 THEN 1 ELSE 0 END) as waiting_parts_tasks'),
                DB::raw('SUM(CASE WHEN rr.repair_status_id = 4 THEN 1 ELSE 0 END) as completed_tasks'),
                DB::raw('SUM(CASE WHEN rr.repair_status_id = 5 THEN 1 ELSE 0 END) as cannot_fix_tasks'),
                DB::raw('SUM(rd.repair_costs) as total_cost')
            )
            ->whereNotNull('rr.technician_id')
            ->where('ut.user_type_name', '=', 'ช่าง') // เลือกเฉพาะช่าง
            ->groupBy('rr.technician_id', 'u.name')
            ->orderBy('technician_name')
            ->get();

        // Send all data to the view
        return view('repair.repairmain', [
            'repairs' => $repairs,
            'reportCounts' => $reportCounts,
            'totalCost' => $totalCost,
            'costsByYear' => $costsByYear,
            'technicianPerformance' => $technicianPerformance,
        ]);
    }



    public function index()
    {
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_detail.repair_costs', // เพิ่มค่าใช้จ่ายที่ดึงมาจากตาราง
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.name as requester_first_name', // Adjusted to correct column
                'requester_type.user_type_name as requester_type_name',
                'technician.name as technician_first_name', // Adjusted to correct column
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
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_detail.repair_costs', // เพิ่มค่าใช้จ่ายที่ดึงมาจากตาราง
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.name as requester_first_name', // Adjusted to correct column
                'requester_type.user_type_name as requester_type_name',
                'technician.name as technician_first_name', // Adjusted to correct column
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
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_detail.repair_costs', // เพิ่มค่าใช้จ่ายที่ดึงมาจากตาราง
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.name as requester_first_name', // Adjusted to correct column
                'requester_type.user_type_name as requester_type_name',
                'technician.name as technician_first_name', // Adjusted to correct column
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
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                'request_detail.*',
                'request_detail.repair_costs', // เพิ่มค่าใช้จ่ายที่ดึงมาจากตาราง
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.name as requester_first_name', // Adjusted to correct column
                'requester_type.user_type_name as requester_type_name',
                'technician.name as technician_first_name', // Adjusted to correct column
                'technician_type.user_type_name as technician_type_name'
            )
            ->where('repair_status.repair_status_id', 5) // กรองเฉพาะ repair_status_id = 5
            ->get();

        return view('repair.repaircancle', compact('repairs'));
    }

    public function technicianRepairs()
    {
        // ดึงรายการแจ้งซ่อมที่ช่างผู้ล็อกอินอยู่เป็นผู้รับผิดชอบ
        $repairs = DB::table('request_detail')
            ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
            ->join('repair_status', 'request_repair.repair_status_id', '=', 'repair_status.repair_status_id')
            ->join('user as requester', 'request_repair.user_user_id', '=', 'requester.id') // Join with requester user
            ->join('user_type as requester_type', 'requester.user_type_id', '=', 'requester_type.user_type_id') // Join with user_type table for requester
            ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.id') // Left join with technician user
            ->leftJoin('user_type as technician_type', 'technician.user_type_id', '=', 'technician_type.user_type_id') // Join with user_type table for technician
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY request_repair.request_repair_at DESC) as display_id'), // เพิ่มคอลัมน์ใหม่
                'request_detail.*',
                'request_repair.request_repair_at',
                'request_repair.update_status_at',
                'repair_status.repair_status_name',
                'repair_status.repair_status_id',
                'requester.name as requester_first_name',
                'requester_type.user_type_name as requester_type_name',
                'technician.name as technician_first_name',
                'technician_type.user_type_name as technician_type_name'
            )
            ->where('request_repair.technician_id', Auth::user()->id) // Filter by logged-in technician
            ->orderBy('request_repair.request_repair_at', 'desc') // Optional: order by request date
            ->get();

        return view('repair.technician_repairs', compact('repairs'));
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

    public function updateRepairStatus(Request $request, $id)
    {
        $request->validate([
            'repair_status_id' => 'required|integer|exists:repair_status,repair_status_id',
            'request_repair_note' => 'nullable|string|max:255',
            'repair_costs' => 'nullable|numeric|min:0', // เพิ่ม validation สำหรับ repair_costs
        ]);

        $requestRepairId = DB::table('request_detail')
            ->where('request_detail_id', $id)
            ->value('request_repair_id');

        if ($requestRepairId) {
            // อัปเดตสถานะในตาราง request_repair
            DB::table('request_repair')
                ->where('request_repair_id', $requestRepairId)
                ->update([
                    'repair_status_id' => $request->repair_status_id,
                    'update_status_at' => now(),
                ]);

            // อัปเดตบันทึกและค่าใช้จ่ายในตาราง request_detail
            DB::table('request_detail')
                ->where('request_detail_id', $id)
                ->update([
                    'request_repair_note' => $request->request_repair_note,
                    'repair_costs' => $request->repair_costs, // อัปเดต repair_costs
                ]);

            // ดึงข้อมูลรายละเอียดเพื่อใช้ส่งอีเมล
            $repairDetails = DB::table('request_detail')
                ->join('request_repair', 'request_detail.request_repair_id', '=', 'request_repair.request_repair_id')
                ->join('user as reporter', 'request_repair.user_user_id', '=', 'reporter.id')
                ->leftJoin('user as technician', 'request_repair.technician_id', '=', 'technician.id')
                ->select(
                    'reporter.name as reporter_name',
                    'reporter.email as reporter_email',
                    'request_detail.asset_name',
                    'request_detail.asset_symptom_detail',
                    'request_detail.location',
                    'request_detail.asset_number',
                    'request_detail.request_repair_note',
                    'request_detail.repair_costs', // เพิ่มค่าใช้จ่ายในข้อมูลที่ส่งอีเมล
                    'request_repair.repair_status_id',
                    'request_repair.request_repair_at',
                    'request_repair.update_status_at',
                    'technician.name as technician_name'
                )
                ->where('request_detail.request_detail_id', $id)
                ->first();

            if ($repairDetails) {
                // แปลงสถานะการซ่อมให้เป็นข้อความ
                $statusMap = [
                    1 => 'รอดำเนินการ',
                    2 => 'กำลังดำเนินการ',
                    3 => 'รออะไหล่',
                    4 => 'ดำเนินการเสร็จสิ้น',
                    5 => 'ซ่อมไม่ได้',
                ];
                $repairDetails->repair_status_text = $statusMap[$repairDetails->repair_status_id] ?? 'ไม่ทราบ';

                // ส่งอีเมลแจ้งเตือนไปยังผู้แจ้ง
                Mail::to($repairDetails->reporter_email)->queue(new RepairStatusNotification($repairDetails));
            }

            return redirect()->back()->with('success', 'สถานะการซ่อมและค่าใช้จ่ายถูกอัปเดตเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบรายการซ่อมที่เกี่ยวข้อง');
        }
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

        DB::transaction(function () use ($request, $validatedData) {
            // Insert into request_repair table first
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
        $reporter = DB::table('user')->where('id', $request->input('user_full_name'))->first();
        $technician = DB::table('user')->where('id', $request->input('technician_id'))->first();

        // Prepare the repair details data
        $repairDetails = [
            'asset_name' => $validatedData['asset_name'],
            'symptom_detail' => $request->input('symptom_detail'),
            'location' => $validatedData['location'],
            'asset_number' => $validatedData['asset_number'] ?? null,
            'request_repair_at' => now(),
        ];


        // Send email notifications to both reporter and technician
        Mail::to($reporter->email)->queue(new RepairRequestNotification($repairDetails, $technician, $reporter));
        Mail::to($technician->email)->queue(new RepairRequestNotification($repairDetails, $technician, $reporter));

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
