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
            // 'asset_paln' => 'required',
            // 'asset_project' => 'required',
            // 'asset_activity' => 'required',
            // 'asset_baget' => 'required',
            // 'asset_fund' => 'required', 
            // 'asset_faculty' => 'required',
            // 'asset_major' => 'required',
            // 'asset_location' => 'required',
            // 'asset_reception_type' => 'required',
            // 'deteriorated_total' => 'required',
            // 'scrap_price' => 'required',
            // 'deteriorated_account' => 'required',
            // 'deteriorated' => 'required',
            // 'deteriorated_at' => 'required',
            // 'asset_deteriorated_stop' => 'required',
            // 'asset_get' => 'required',
            // 'asset_status' => 'required',
            // 'asset_document_number' => 'required',
            // 'asset_countingunit' => 'required',
            // 'deteriorated_price' => 'required',
            // 'asset_price_account' => 'required',
            // 'asset_account' => 'required',
            // 'deteriorated_total_account' => 'required',
            // 'asset_live' => 'required',
            // 'deteriorated_end' => 'required'
        ]);


        $data = [
            'asset_name' => $request->asset_name,
            'asset_price' => $request->asset_price,
            'asset_regis_at' => Carbon::parse($request->asset_regis_at)->toDateTimeString(),
            'asset_created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            // 'asset_status_id' => $request->asset_status_id,
            'asset_comment' => $request->asset_comment,
            'asset_number' => $request->asset_number,
            'updated_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'asset_paln'  => $request->asset_paln,
            'asset_project' => $request->asset_project,
            'asset_activity' => $request->asset_activity,
            'asset_budget' => $request->asset_baget,
            'asset_fund' => $request->asset_fund,
            // 'asset_faculty' => $request->asset_faculty,
            'asset_major' => $request->major,
            'asset_location' => $request->asset_location,
            'asset_reception_type' => $request->asset_reception_type,
            'asset_deteriorated_total' => $request->deteriorated_total,
            'asset_scrap_price' => $request->scrap_price,
            'asset_deteriorated_account' => $request->deteriorated_account,
            'asset_deteriorated' => $request->deteriorated,
            'asset_deteriorated_at' => $request->deteriorated_at,
            'asset_deteriorated_stop' => $request->asset_deteriorated_stop,
            'asset_get' => $request->asset_get,
            // 'asset_status' => $request->asset_status,
            'asset_document_number' => $request->asset_document_number,
            'asset_countingunit' => $request->asset_countingunit,
            'asset_deteriorated_price' => $request->deteriorated_price,
            'asset_price_account' => $request->asset_price_account,
            'asset_account' => $request->asset_account,
            'asset_deteriorated_total_account' => $request->deteriorated_total_account,
            'asset_live'=> $request->asset_live,
            'asset_deteriorated_end' => $request->deteriorated_end
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

    public function update(Request $request,$asset_id)
    {
        //
        $request->validate([
            'asset_name' => 'required',
            'asset_price' => 'required',
            'asset_regis_at' => 'required',
            'asset_created_at' => 'required',
            'asset_status_id' => 'required',
            'asset_comment' => 'required',
            'asset_number' => 'required',
            // 'asset_paln' => 'required',
            // 'asset_project' => 'required',
            // 'asset_activity' => 'required',
            // 'asset_baget' => 'required',
            // 'asset_fund' => 'required', 
            // 'asset_faculty' => 'required',
            // 'asset_major' => 'required',
            // 'asset_location' => 'required',
            // 'asset_reception_type' => 'required',
            // 'deteriorated_total' => 'required',
            // 'scrap_price' => 'required',
            // 'deteriorated_account' => 'required',
            // 'deteriorated' => 'required',
            // 'deteriorated_at' => 'required',
            // 'asset_deteriorated_stop' => 'required',
            // 'asset_get' => 'required',
            // 'asset_status' => 'required',
            // 'asset_document_number' => 'required',
            // 'asset_countingunit' => 'required',
            // 'deteriorated_price' => 'required',
            // 'asset_price_account' => 'required',
            // 'asset_account' => 'required',
            // 'deteriorated_total_account' => 'required',
            // 'asset_live' => 'required',
            // 'deteriorated_end' => 'required'
        ]);


        $data = [
            'asset_name' => $request->asset_name,
            'asset_price' => $request->asset_price,
            'asset_regis_at' => Carbon::parse($request->asset_regis_at)->toDateTimeString(),
            'asset_created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            // 'asset_status_id' => $request->asset_status_id,
            'asset_comment' => $request->asset_comment,
            'asset_number' => $request->asset_number,
            'updated_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'created_at' => Carbon::now()->toDateTimeString(), // ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น
            'asset_paln'  => $request->asset_paln,
            'asset_project' => $request->asset_project,
            'asset_activity' => $request->asset_activity,
            'asset_budget' => $request->asset_baget,
            'asset_fund' => $request->asset_fund,
            // 'asset_faculty' => $request->asset_faculty,
            'asset_major' => $request->major,
            'asset_location' => $request->asset_location,
            'asset_reception_type' => $request->asset_reception_type,
            'asset_deteriorated_total' => $request->deteriorated_total,
            'asset_scrap_price' => $request->scrap_price,
            'asset_deteriorated_account' => $request->deteriorated_account,
            'asset_deteriorated' => $request->deteriorated,
            'asset_deteriorated_at' => $request->deteriorated_at,
            'asset_deteriorated_stop' => $request->asset_deteriorated_stop,
            'asset_get' => $request->asset_get,
            // 'asset_status' => $request->asset_status,
            'asset_document_number' => $request->asset_document_number,
            'asset_countingunit' => $request->asset_countingunit,
            'asset_deteriorated_price' => $request->deteriorated_price,
            'asset_price_account' => $request->asset_price_account,
            'asset_account' => $request->asset_account,
            'asset_deteriorated_total_account' => $request->deteriorated_total_account,
            'asset_live'=> $request->asset_live,
            'asset_deteriorated_end' => $request->deteriorated_end
        ];

        DB::table('asset_main')->where('asset_id', $asset_id)->update($data);
        return redirect('/index');
    }

    public function delete($asset_id)
    {
        //
        DB::table('asset_main')->where('asset_id', $asset_id)->delete();
        return redirect()->back();
    }
}
