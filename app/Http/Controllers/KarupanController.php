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
    public function index()
    {
        // ดึงข้อมูลทั้งหมดจาก AssetMain
        $asset = AssetMain::all();
        return view('karupan.index', compact('asset'));
    }

    public function store(Request $request)
    {
        // ตรวจสอบและ validate ข้อมูลที่ส่งมาจากฟอร์ม
        $validated = $request->validate([
            'asset_number' => 'required|string|max:255|unique:asset_main,asset_number',
            'asset_name' => 'required|string|max:255',
            'asset_price' => 'required|numeric|min:0',
            'asset_budget' => 'required|string|max:50',
            'asset_location' => 'required|string|max:255',
            'faculty_faculty_id' => 'required|string|max:255', // หน่วยงาน
            'asset_major' => 'required|string|max:255', // ชื่อหน่วยงาน
            'room_building_id' => 'required|string|max:255', // หน่วยงานย่อย
            'room_room_id' => 'required|string|max:255', // ใช้ประจำที่
            'asset_comment' => 'nullable|string|max:255', // ผลการตรวจสอบครุภัณฑ์
            'asset_asset_status_id' => 'required|numeric|min:1', // ตรวจสอบการใช้งาน
            'asset_brand' => 'required|string|max:255', // ยี่ห้อ/ชนิดแบบขนาดหมายเลขเครื่อง
            'asset_fund' => 'required|string|max:255', // แหล่งเงิน
            'asset_reception_type' => 'required|string|max:255', // วิธีการได้มา
        ]);

        // สร้างข้อมูลใหม่ในฐานข้อมูล
        $asset = AssetMain::create($validated);

        // ส่งข้อมูลกลับเป็น JSON
        return response()->json($asset);
    }

    public function edit($id)
    {
        // ค้นหาข้อมูลตาม ID
        $asset = AssetMain::findOrFail($id);
        return response()->json($asset);
    }

    public function update(Request $request, $id)
    {
        // ตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'asset_number' => 'required|string|max:255|unique:asset_main,asset_number,' . $id,
            'asset_name' => 'required|string|max:255',
            'asset_price' => 'required|numeric|min:0',
            'asset_budget' => 'required|string|max:50',
            'asset_location' => 'required|string|max:255',
            'faculty_faculty_id' => 'required|string|max:255', // หน่วยงาน
            'asset_major' => 'required|string|max:255', // ชื่อหน่วยงาน
            'room_building_id' => 'required|string|max:255', // หน่วยงานย่อย
            'room_room_id' => 'required|string|max:255', // ใช้ประจำที่
            'asset_comment' => 'nullable|string|max:255', // ผลการตรวจสอบครุภัณฑ์
            'asset_asset_status_id' => 'required|numeric|min:1', // ตรวจสอบการใช้งาน
            'asset_brand' => 'required|string|max:255', // ยี่ห้อ/ชนิดแบบขนาดหมายเลขเครื่อง
            'asset_fund' => 'required|string|max:255', // แหล่งเงิน
            'asset_reception_type' => 'required|string|max:255', // วิธีการได้มา
        ]);

        // ค้นหาข้อมูล asset ตาม ID
        $asset = AssetMain::findOrFail($id);

        // อัปเดตข้อมูลในฐานข้อมูล
        $asset->update($validated);

        // ส่งข้อมูลกลับ
        return response()->json($asset);
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
