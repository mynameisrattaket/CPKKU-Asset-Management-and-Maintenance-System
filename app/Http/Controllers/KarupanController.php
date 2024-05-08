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
            'asset_number' => 'required'
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
        ];
        
        DB::table('asset_main')->insert($data);
        return redirect('/');

    }

    public function show($id)
    {
        //
    }

    public function edit($asset_id)
    {
        //
        DB::table('asset_main')->where('asset_id',$asset_id)->first();
        return view('karupan.edit', compact('asset'));
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
            'asset_number' => 'required'
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
        ];
        
        DB::table('asset_main')->insert($data);
        return redirect('/');
    }

    public function delete($asset_id)
    {
        //
        DB::table('asset_main')->where('asset_id', $asset_id)->delete();
        return redirect()->back();
    }
}
