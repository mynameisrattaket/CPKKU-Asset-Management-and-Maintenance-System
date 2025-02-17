<?php

namespace App\Http\Controllers;

use App\Models\Karupan;
use App\Models\AssetMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class KarupanController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลทั้งหมดจาก AssetMain
        $asset = AssetMain::all();
        $statuses = DB::table('asset_status')->get(); // ดึงข้อมูลจากฐานข้อมูล

        return view('karupan.index', compact('asset', 'statuses')); // ส่ง $statuses ไปยัง View
    }


    // ✅ ฟังก์ชันตรวจสอบหมายเลขครุภัณฑ์ซ้ำ
    private function isDuplicateAssetNumber($assetNumber, $excludeId = null)
    {
        $query = AssetMain::where('asset_number', $assetNumber);

        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }

        return $query->exists();
    }


    // ✅ ฟังก์ชันเพิ่มข้อมูลครุภัณฑ์
    public function store(Request $request)
    {
        try {
            Log::info($request->all());

            // ตรวจสอบหมายเลขครุภัณฑ์ซ้ำ
            if ($this->isDuplicateAssetNumber($request->asset_number)) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'หมายเลขครุภัณฑ์นี้มีอยู่แล้ว!'
                ], 422);
            }

            // ตรวจสอบข้อมูลที่รับมา
            $validated = $request->validate($this->getValidationRules());

            // เพิ่มข้อมูลใหม่
            $asset = AssetMain::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'เพิ่มข้อมูลครุภัณฑ์เรียบร้อย',
                'asset' => $asset
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการตรวจสอบข้อมูล',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ ฟังก์ชันแก้ไขข้อมูลครุภัณฑ์
    public function update(Request $request, $id)
    {
        try {
            $asset = AssetMain::findOrFail($id);

            // ตรวจสอบหมายเลขครุภัณฑ์ซ้ำ
            if ($this->isDuplicateAssetNumber($request->asset_number, $id)) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'หมายเลขครุภัณฑ์นี้มีอยู่แล้ว!'
                ], 422);
            }

            // ตรวจสอบข้อมูลที่รับมา
            $validated = $request->validate($this->getValidationRules());

            // อัปเดตข้อมูล
            $asset->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'อัปเดทรายการครุภัณฑ์เรียบร้อย',
                'asset' => $asset
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✅ ฟังก์ชันตรวจสอบว่าหมายเลขครุภัณฑ์ซ้ำหรือไม่
    public function checkDuplicate(Request $request)
    {
        $assetNumber = $request->input('asset_number');
        $assetId = $request->input('asset_id');

        if ($this->isDuplicateAssetNumber($assetNumber, $assetId)) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'หมายเลขครุภัณฑ์นี้มีอยู่แล้ว!'
            ], 422);
        }

        return response()->json(['status' => 'unique']);
    }

    // ✅ ฟังก์ชันดึงข้อมูลครุภัณฑ์
    public function edit($id)
    {
        $asset = AssetMain::findOrFail($id);
        return response()->json($asset);
    }

    // ✅ ฟังก์ชันกำหนด Validation Rules
    private function getValidationRules()
    {
        return [
            'asset_number' => 'required|string|max:255',
            'asset_name' => 'required|string|max:255',
            'asset_asset_status_id' => 'required|numeric|min:1',
            'asset_price' => 'nullable|numeric|min:0',
            'asset_budget' => 'nullable|string|max:50',
            'asset_location' => 'nullable|string|max:255',
            'faculty_faculty_id' => 'nullable|string|max:255',
            'asset_major' => 'nullable|string|max:255',
            'room_building_id' => 'nullable|string|max:255',
            'room_room_id' => 'nullable|string|max:255',
            'asset_comment' => 'nullable|string|max:255',
            'asset_brand' => 'nullable|string|max:255',
            'asset_fund' => 'nullable|string|max:255',
            'asset_reception_type' => 'nullable|string|max:255',
            'asset_regis_at' => 'nullable|date',
            'asset_created_at' => 'nullable|date',
            'asset_plan' => 'nullable|string|max:255',
            'asset_project' => 'nullable|string|max:255',
            'asset_sn_number' => 'nullable|string|max:255',
            'asset_activity' => 'nullable|string|max:255',
            'asset_deteriorated_total' => 'nullable|numeric|min:0',
            'asset_scrap_price' => 'nullable|numeric|min:0',
            'asset_deteriorated_account' => 'nullable|numeric|min:0',
            'asset_deteriorated' => 'nullable|numeric|min:0',
            'asset_deteriorated_at' => 'nullable|date',
            'asset_deteriorated_stop' => 'nullable|date',
            'asset_get' => 'nullable|string|max:255',
            'asset_document_number' => 'nullable|string|max:255',
            'asset_countingunit' => 'nullable|string|max:50',
            'asset_deteriorated_price' => 'nullable|numeric|min:0',
            'asset_price_account' => 'nullable|numeric|min:0',
            'asset_account' => 'nullable|string|max:255',
            'asset_deteriorated_total_account' => 'nullable|numeric|min:0',
            'asset_live' => 'nullable|numeric|min:0',
            'asset_deteriorated_end' => 'nullable|date',
            'asset_code' => 'nullable|string|max:255',
            'asset_amount' => 'nullable|numeric|min:0',
            'asset_warranty_start' => 'nullable|date',
            'asset_warranty_end' => 'nullable|date',
            'user_import_id' => 'nullable|numeric',
            'asset_detail' => 'nullable|string|max:255',
            'asset_type' => 'nullable|string|max:255',
            'asset_how' => 'nullable|string|max:255',
            'asset_company' => 'nullable|string|max:255',
            'asset_company_address' => 'nullable|string|max:255',
            'asset_type_sub' => 'nullable|string|max:255',
            'asset_type_main' => 'nullable|string|max:255',
            'asset_revenue' => 'nullable|string|max:255',
            'asset_img' => 'nullable|string|max:255',
            'room_floor_id' => 'nullable|string|max:255',
        ];
    }



    public function destroy($id)
    {
        // ค้นหาข้อมูล asset ตาม ID
        $asset = AssetMain::findOrFail($id);

        // ลบข้อมูล
        $asset->delete();

        // ส่งข้อความกลับ
        return response()->json(['message' => 'Deleted successfully']);
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
        return view('karupan/search', compact('asset_main'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
}
