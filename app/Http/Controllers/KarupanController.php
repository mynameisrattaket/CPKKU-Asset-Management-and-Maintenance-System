<?php

namespace App\Http\Controllers;

use App\Models\Karupan;
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

<<<<<<< HEAD
    public function insert_karupan(Request $request)
    {
        $request->validate([
            'asset_id' => 'nullable|int|max:255',
            'asset_name' => 'required',
            'asset_price' => 'required',
            'asset_regis_at' => 'required|date',
            'asset_created_at' => 'required|date',
            'asset_status_id' => 'required',
            'asset_comment' => 'required',
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
        ]);
=======
    public function show($id){

        // $asset = Karupan::findOrFail($request); // ค้นหาข้อมูลตามไอดี
        $asset=DB::table('asset_main')->where('asset_id', $id )->first();
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
        'asset_status_id' => 'required',
        'asset_comment' => 'required',
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
    ]);
>>>>>>> 191562218c3fc37555fdf3df867e71b0b8f049b9


        $maxAssetNumber = DB::table('asset_main')->max('asset_number');
        $nextAssetNumber = $maxAssetNumber ? $maxAssetNumber + 1 : 1000000000000;

        $dataToInsert = [];

    
        for ($i = 0; $i < $request->asset_amount; $i++) {

        if (strlen((string)$nextAssetNumber) > 13) {
            return redirect('/')->with('error', 'เลข asset_number เกิน 13 หลัก');
        }

        $dataToInsert[] = [
            'asset_id' => $this->makeid(5),
            'asset_name' => $request->asset_name,
            'asset_price' => $request->asset_price,
            'asset_regis_at' => Carbon::parse($request->asset_regis_at)->toDateTimeString(),
            'asset_created_at' => Carbon::now()->toDateTimeString(),
            'asset_status_id' => $request->asset_status_id,
            'asset_comment' => $request->asset_comment,
            'asset_number' => 'คพ.' . $nextAssetNumber,
            'updated_at' => Carbon::now()->toDateTimeString(),
            'created_at' => Carbon::now()->toDateTimeString(),
            'asset_paln' => $request->asset_paln,
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

        $nextAssetNumber++;
    }

        DB::table('asset_main')->insert($dataToInsert);

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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
}