<?php

namespace App\Http\Controllers;

use App\Models\Karupan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KarupanController extends Controller
{
    protected $tablename;
    public function index()
    {
            $asset=DB::table('asset_main')->get();
            $asset = Karupan::paginate(10);
            return view('index',compact('asset'));
    }

    public function insert_karupan(Request $request)
    {
        $request->validate([
            'asset_name' => 'required',
            'asset_price' => 'required',
            'asset_regis_at' => 'required',
            'asset_created_at' => 'required',
            'asset_status_id' => 'required',
            'asset_comment' => 'required',
            'asset_number' => 'required',
            'asset_paln' => 'required',
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
            'asset_deteriorated_at' => 'required',
            'asset_deteriorated_stop' => 'required',
            'asset_get' => 'required',
            'asset_document_number' => 'required',
            'asset_countingunit' => 'required',
            'asset_deteriorated_price' => 'required',
            'asset_price_account' => 'required',
            'asset_account' => 'required',
            'asset_deteriorated_total_account' => 'required',
            'asset_live' => 'required',
            'asset_deteriorated_end' => 'required'
        ]);


        $data = [
            'asset_name' => $request->asset_name,
            'asset_price' => $request->asset_price,
            'asset_regis_at' => Carbon::parse($request->asset_regis_at)->toDateTimeString(),
            'asset_created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'asset_status_id' => $request->asset_status_id,
            'asset_comment' => $request->asset_comment,
            'asset_number' => $request->asset_number,
            'updated_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'asset_paln'  => $request->asset_paln,
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
            'asset_deteriorated_at' => $request->asset_deteriorated_at,
            'asset_deteriorated_stop' => $request->asset_deteriorated_stop,
            'asset_get' => $request->asset_get,
            'asset_document_number' => $request->asset_document_number,
            'asset_countingunit' => $request->asset_countingunit,
            'asset_deteriorated_price' => $request->asset_deteriorated_price,
            'asset_price_account' => $request->asset_price_account,
            'asset_account' => $request->asset_account,
            'asset_deteriorated_total_account' => $request->asset_deteriorated_total_account,
            'asset_live'=> $request->asset_live,
            'asset_deteriorated_end' => $request->asset_deteriorated_end
        ];
        DB::table('asset_main')->insert($data);
        return redirect('/');
    }

    public function show($asset_id)
    {
        //
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
        DB::table('asset_main')->where('asset_id', $request->assetId)->update($data);
        
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
        DB::table('asset_main')->where('asset_id', $asset_id)->delete();
        return redirect()->back();
    }

    public function search(Request $request)
    {
    // รับค่าการค้นหาจากฟอร์ม
    $searchasset = $request->input('searchasset');
    $asset_number = $request->input('asset_number');
    $asset_price = $request->input('asset_price');
    $asset_status_id = $request->input('asset_status_id');
    $asset_comment = $request->input('asset_comment');

    // แยกคำค้นหาออกเป็นคำสั้นๆ
    $keywords = explode(' ', $searchasset);


    // ค้นหาข้อมูลครุภัณฑ์ที่ตรงกับการค้นหา
     $query = DB::table('asset_main');
    foreach ($keywords as $keyword) {
        $query->where(function($query) use ($keyword) {
            $query->where('asset_name', 'LIKE', "%$keyword%")
                  ->orWhere('asset_number', 'LIKE', "%$keyword%")
                  ->orWhere('asset_price', 'LIKE', "%$keyword%")
                  ->orWhere('asset_status_id', 'LIKE', "%$keyword%")
                  ->orWhere('asset_comment', 'LIKE', "%$keyword%");
        });
    }
    if (!empty($asset_number)) {
        $query->where('asset_number', 'LIKE', "%$asset_number%");
    }
    if (!empty($asset_price)) {
        $query->where('asset_price', 'LIKE', "%$asset_price%");
    }
    if (!empty($asset_status_id)) {
        $query->where('asset_status_id', 'LIKE', "%$asset_status_id%");
    }
    if (!empty($asset_comment)) {
        $query->where('asset_comment', 'LIKE', "%$asset_comment%");
    }

    $asset_main = $query->get();

    // ส่งข้อมูลไปยังหน้า view
    return view('search', compact('asset_main'));
    }

}
