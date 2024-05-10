<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repair;
use Illuminate\Support\Facades\DB;

class RepairController extends Controller
{
    public function repair(Request $request)
    {
        $search = $request->input('search');
        $request_detail = DB::table('request_detail')
            ->where('asset_name', 'LIKE', "%$search%")
            ->orWhere('asset_symptom_detail', 'LIKE', "%$search%")
            ->orWhere('asset_number', 'LIKE', "%$search%")
            ->orWhere('asset_symptom_detail', 'LIKE', "%$search%")
            ->orWhere('location', 'LIKE', "%$search%")
            ->get();

        return view('repair', compact('request_detail'));
    }

    public function showAddForm()
    {
        return view('add_repair_request');
    }

    public function storeRepairRequest(Request $request)
    {
        $validatedData = $request->validate([
            'asset_number' => 'required',
            'asset_name' => 'required',
            'symptom_detail' => 'required',
            'location' => 'required',
        ]);

        DB::table('request_detail')->insert([
            'asset_number' => $validatedData['asset_number'],
            'asset_name' => $validatedData['asset_name'],
            'asset_symptom_detail' => $validatedData['symptom_detail'],
            'location' => $validatedData['location'],
        ]);

        $request_detail = DB::table('request_detail')->get();

        return view('repair', compact('request_detail'))->with('success', 'เพิ่มข้อมูลการแจ้งซ่อมสำเร็จ');
    }
}
