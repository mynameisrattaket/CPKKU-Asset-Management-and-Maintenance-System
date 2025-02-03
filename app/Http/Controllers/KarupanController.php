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
        $asset = AssetMain::all();
        return view('karupan/index', compact('asset'));
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
    public function delete($asset_id)
    {
        //
        DB::table('asset_main')->where('asset_id', $asset_id)->update(['deleted_at' => now()]);

        $asset = AssetMain::all();
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
        return view('karupan/search', compact('asset_main'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
}
