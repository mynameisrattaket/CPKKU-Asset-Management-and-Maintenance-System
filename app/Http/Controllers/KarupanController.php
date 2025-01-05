<?php

namespace App\Http\Controllers;

use App\Models\Karupan;
use App\Models\AssetMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;



class KarupanController extends Controller
{
    protected $tablename;


    public function index()
    {
        $asset = Karupan::all();
        return view('index', compact('asset'));
        // print_r($assets);
    }

    public function create()
    {
            return view('karupan.create');
    }

    public function makeid($length) {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= rand(0, 9); // สร้างตัวเลขสุ่ม
        }
        return $randomString;
    }

    public function show($id)
    {
        // ดึงข้อมูลพร้อมความสัมพันธ์
        $asset = AssetMain::with('asset_status')->find($id);

        // ตรวจสอบว่าพบข้อมูลหรือไม่
        if (!$asset) {
            abort(404, 'Asset not found');
        }

        // ส่งข้อมูลไปยัง view
        return view('assetdetaill', compact('asset'));
    }



    public function insert_karupan(Request $request){

        // Validate the input
        $request->validate([
            'asset_id' => 'nullable|int|max:255',
            'asset_name' => 'required',
            'asset_price' => 'required',
            'asset_regis_at' => 'required|date',
            'asset_created_at' => 'required|date',
            'asset_asset_status_id' => 'required',
            'asset_comment' => 'required',
            'asset_plan' => 'required',
            'asset_project' => 'required',
            'asset_activity' => 'required',
            'asset_budget' => 'required',
            'asset_fund' => 'required',
            'asset_major' => 'required',
            'asset_location' => 'required',
            'asset_reception_type' => 'required',
            'asset_deteriorated_total' => 'required',
            'asset_scrap_price' => 'required',
            'asset_deteriorated_account' => 'required',
            'asset_deteriorated' => 'required',
            'asset_deteriorated_at' => 'required|date',
            'asset_deteriorated_stop' => 'required|date',
            'asset_get' => 'required',
            'asset_document_number' => 'required',
            'asset_countingunit' => 'required',
            'asset_deteriorated_price' => 'required',
            'asset_price_account' => 'required',
            'asset_account' => 'required',
            'asset_deteriorated_total_account' => 'required',
            'asset_live' => 'required',
            'asset_deteriorated_end' => 'required|date',
            'asset_amount' => 'required|integer|min:1',
            'asset_prefix' => 'required|string|max:5',
            'other_asset_prefix' => 'nullable|string|max:5',
            'asset_number' => 'nullable|integer' // เพิ่มการตรวจสอบ asset_number
        ]);

        $comment = $request->has('asset_comment') ? $request->asset_comment : null;

        // Check if asset_amount is a positive integer
        if (!is_numeric($request->asset_amount) || $request->asset_amount < 1 || floor($request->asset_amount) != $request->asset_amount) {
            return redirect('/')->with('error', 'จำนวนครุภัณฑ์ต้องเป็นจำนวนเต็มบวก');
        }

        // ตรวจสอบว่าผู้ใช้เลือก "อื่นๆ" หรือไม่
        $prefix = $request->input('asset_prefix') === 'other' ? $request->input('other_asset_prefix') : $request->input('asset_prefix');

        // ดึงหมายเลขทรัพย์สินสูงสุดและแยก prefix ออก
        $maxAssetNumber = DB::table('asset_main')->where('asset_number', 'like', $prefix . '%')->max('asset_number');
        if ($maxAssetNumber) {
            // แยกส่วนที่เป็นตัวเลขออกจาก prefix
            $maxNumber = (int) substr($maxAssetNumber, strlen($prefix));
        } else {
            $maxNumber = 1000000000000;  // กำหนดให้เริ่มต้นที่
        }

        // ใช้ asset_number ที่ป้อนเข้ามาหากมี มิฉะนั้นใช้ค่าที่คำนวณได้
        $nextAssetNumber = $request->filled('asset_number') ? $request->input('asset_number') : $maxNumber + 1;

        $dataToInsert = [];

        for ($i = 0; $i < $request->asset_amount; $i++) {
            if (strlen((string)$nextAssetNumber) > 13) {
                return redirect('/')->with('error', 'เลข asset_number เกิน 13 หลัก');
            }
            $assetNumber = $prefix . $nextAssetNumber;
            $nextAssetNumber++;

            $dataToInsert[] = [
                'asset_id' => $this->makeid(5),
                'asset_name' => $request->asset_name,
                'asset_price' => $request->asset_price,
                'asset_regis_at' => Carbon::parse($request->asset_regis_at)->toDateTimeString(),
                'asset_created_at' => Carbon::now()->toDateTimeString(),
                'asset_asset_status_id' => $request->asset_asset_status_id,
                'asset_comment' => $comment,
                'asset_number' => $assetNumber,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'asset_plan' => $request->asset_plan,
                'asset_project' => $request->asset_project,
                'asset_activity' => $request->asset_activity,
                'asset_budget' => $request->asset_budget,
                'asset_fund' => $request->asset_fund,
                'asset_major' => $request->asset_major,
                'asset_location' => $request->asset_location,
                'asset_reception_type' => $request->asset_reception_type,
                'asset_deteriorated_total' => $request->asset_deteriorated_total,
                'asset_scrap_price' => $request->asset_scrap_price,
                'asset_deteriorated_account' => $request->asset_deteriorated_account,
                'asset_deteriorated' => $request->asset_deteriorated,
                'asset_deteriorated_at' => Carbon::parse($request->asset_deteriorated_at)->toDateTimeString(),
                'asset_deteriorated_stop' => Carbon::parse($request->asset_deteriorated_stop)->toDateTimeString(),
                'asset_get' => $request->asset_get,
                'asset_document_number' => $request->asset_document_number,
                'asset_countingunit' => $request->asset_countingunit,
                'asset_deteriorated_price' => $request->asset_deteriorated_price,
                'asset_price_account' => $request->asset_price_account,
                'asset_account' => $request->asset_account,
                'asset_deteriorated_total_account' => $request->asset_deteriorated_total_account,
                'asset_live' => $request->asset_live,
                'asset_deteriorated_end' => Carbon::parse($request->asset_deteriorated_end)->toDateTimeString(),
                'asset_amount' => 1
            ];
        }

        DB::table('asset_main')->insert($dataToInsert);

        try {
            // โค้ดการเพิ่มข้อมูลลงในฐานข้อมูล
        } catch (\Exception $e) {
            // จัดการข้อผิดพลาดที่เกิดขึ้นในขณะเพิ่มข้อมูล
            return redirect('/')->with('error', 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล: ' . $e->getMessage());
        }

        return redirect('/')->with('success', 'Insert สำเร็จ');
    }



    public function edit_karupan(Request $request)
    {
        //
        $asset=DB::table('asset_main')->where('asset_id', $request->assetId )->first();
        return response()->json($asset);
    }

    public function update_karupan(Request $request)
    {

        // $data = [
        //     // 'ID' => $request->assetId,
        //     'asset_comment' =>  $request->comment
        // ];
        // print_r($request->assetId);
        // if (!$request->$assetId) {
        //     return response()->json(['message' => 'Asset ID is missing'], 400);
        // }

        // Validate ข้อมูลที่ส่งมา
        // $request->validate([
        //     'asset_name' => 'required',
        //     'asset_price' => 'required',
        // ]);

        // // เตรียมข้อมูลสำหรับอัพเดต
        // $data = [
        //     'asset_name' => $request->input('asset_name'),
        //     'asset_price' => $request->input('asset_price'),
        //     'updated_at' => Carbon::now()->toDateTimeString(),
        // ];

        // // อัพเดตข้อมูลในฐานข้อมูล
        $data = [
            'asset_Name' => $request->assetGetName,
            'asset_price' => $request->assetprice,
            'asset_regis_at' => Carbon::parse($request->assetregis_at)->toDateTimeString(),
            'asset_created_at' => Carbon::now()->toDateTimeString(),
            'asset_status_id' => $request->assetstatus_id,
            'asset_number' => $request->assetnumber,
            'asset_comment' => $request->comment2,
            'updated_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
        ];

        // Update the asset_main table
        print_r($request->assetId);
        DB::table('asset_main')->all();

         return response()->json(['message' =>     $data ], 200);
        // // ตรวจสอบว่าอัพเดตสำเร็จหรือไม่
        // if ($updated) {
        //     return response()->json(['message' => 'Update successful for asset_id: ' .$request->$asset_id]);
        // } else {
        //     return response()->json(['message' => 'Update failed for asset_id: ' .$request->$asset_id], 500);
        // }
    }

    // public function update(Request $request)
    // {
    //     $data = $request->all();
    //     return redirect('/');
    // }


    public function delete($asset_id)
    {
        //
        DB::table('asset_main')->where('asset_id', $asset_id)->update(['deleted_at' => now()]);

        $asset = Karupan::all();
        return view('index', compact('asset'));
    }

    public function search(Request $request)
    {
        // รับค่าการค้นหาจากฟอร์ม
        $searchasset = $request->input('searchasset');
        $asset_number = $request->input('asset_number');
        $asset_price = $request->input('asset_price');
        $asset_status_id = $request->input('asset_asset_status_id');
        $asset_comment = $request->input('asset_comment');
        $asset_budget = $request->input('asset_budget');
        $faculty_faculty_id = $request->input('faculty_faculty_id');
        $asset_major = $request->input('asset_major');
        $room_building_id = $request->input('room_building_id');
        $asset_location = $request->input('asset_location');
        $room_room_id = $request->input('room_room_id');
        $asset_brand = $request->input('asset_brand');
        $asset_fund = $request->input('asset_fund');
        $asset_reception_type = $request->input('asset_reception_type');

        // แยกคำค้นหาออกเป็นคำสั้นๆ
        $keywords = explode(' ', $searchasset);

        // ค้นหาข้อมูลครุภัณฑ์ที่ตรงกับการค้นหา
        $query = DB::table('asset_main');

        foreach ($keywords as $keyword) {
            $query->where(function($query) use ($keyword) {
                $query->where('asset_name', 'LIKE', "%$keyword%")
                      ->orWhere('asset_number', 'LIKE', "%$keyword%")
                      ->orWhere('asset_price', 'LIKE', "%$keyword%")
                      ->orWhere('asset_asset_status_id', 'LIKE', "%$keyword%")
                      ->orWhere('asset_comment', 'LIKE', "%$keyword%")
                      ->orWhere('asset_budget', 'LIKE', "%$keyword%")
                      ->orWhere('faculty_faculty_id', 'LIKE', "%$keyword%")
                      ->orWhere('asset_major', 'LIKE', "%$keyword%")
                      ->orWhere('room_building_id', 'LIKE', "%$keyword%")
                      ->orWhere('asset_location', 'LIKE', "%$keyword%")
                      ->orWhere('room_room_id', 'LIKE', "%$keyword%")
                      ->orWhere('asset_brand', 'LIKE', "%$keyword%")
                      ->orWhere('asset_fund', 'LIKE', "%$keyword%")
                      ->orWhere('asset_reception_type', 'LIKE', "%$keyword%");
            });
        }

        // Add individual filters
        if (!empty($asset_number)) {
            $query->where('asset_number', 'LIKE', "%$asset_number%");
        }
        if (!empty($asset_price)) {
            $query->where('asset_price', 'LIKE', "%$asset_price%");
        }
        if (!empty($asset_status_id)) {
            $query->where('asset_asset_status_id', 'LIKE', "%$asset_status_id%");
        }
        if (!empty($asset_comment)) {
            $query->where('asset_comment', 'LIKE', "%$asset_comment%");
        }
        if (!empty($asset_budget)) {
            $query->where('asset_budget', 'LIKE', "%$asset_budget%");
        }
        if (!empty($faculty_faculty_id)) {
            $query->where('faculty_faculty_id', 'LIKE', "%$faculty_faculty_id%");
        }
        if (!empty($asset_major)) {
            $query->where('asset_major', 'LIKE', "%$asset_major%");
        }
        if (!empty($room_building_id)) {
            $query->where('room_building_id', 'LIKE', "%$room_building_id%");
        }
        if (!empty($asset_location)) {
            $query->where('asset_location', 'LIKE', "%$asset_location%");
        }
        if (!empty($room_room_id)) {
            $query->where('room_room_id', 'LIKE', "%$room_room_id%");
        }
        if (!empty($asset_brand)) {
            $query->where('asset_brand', 'LIKE', "%$asset_brand%");
        }
        if (!empty($asset_fund)) {
            $query->where('asset_fund', 'LIKE', "%$asset_fund%");
        }
        if (!empty($asset_reception_type)) {
            $query->where('asset_reception_type', 'LIKE', "%$asset_reception_type%");
        }

        $asset_main = $query->get();

        // ส่งข้อมูลไปยังหน้า view
        return view('search', compact('asset_main'));
    }



    public function saveData(Request $request)
    {
        if ($request->hasFile('excel_file')) {
            $path = $request->file('excel_file')->getRealPath();
            $data = \Excel::load($path)->get();

            if ($data->count()) {
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'ปีงบประมาณ' => $value->ปีงบประมาณ,
                        'หน่วยงาน' => $value->หน่วยงาน,
                        'ชื่อหน่วยงาน' => $value->ชื่อหน่วยงาน,
                        'หน่วยงานย่อย' => $value->หน่วยงานย่อย,
                        'ชื่อหน่วยงานย่อย' => $value->ชื่อหน่วยงานย่อย,
                        'ใช้ประจำที่' => $value->ใช้ประจำที่,
                        'ผลการตรวจสอบครุภัณฑ์' => $value->ผลการตรวจสอบครุภัณฑ์,
                        'หมายเลขครุภัณฑ์' => $value->หมายเลขครุภัณฑ์,
                        'ตรวจสอบการใช้งาน' => $value->ตรวจสอบการใช้งาน,
                        'ชื่อครุภัณฑ์' => $value->ชื่อครุภัณฑ์,
                        'ยี่ห้อ ชนิดแบบขนาดหมายเลขเครื่อง' => $value->ยี่ห้อ_ชนิดแบบขนาดหมายเลขเครื่อง,
                        'ราคาต่อหน่วย' => $value->ราคาต่อหน่วย,
                        'แหล่งเงิน' => $value->แหล่งเงิน,
                        'วิธีการได้มา' => $value->วิธีการได้มา,
                        'สถานะ' => $value->สถานะ
                    ];
                }

                if (!empty($arr)) {
                    DB::table('karupan')->insert($arr);
                    return response()->json(['success' => 'บันทึกข้อมูลเรียบร้อยแล้ว!']);
                }
            }
        }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Process the uploaded file and save the data to the database
        return response()->json(['error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมมูล'], 400);


        return response()->json(['success' => 'Data saved successfully.']);
    }







    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
}
