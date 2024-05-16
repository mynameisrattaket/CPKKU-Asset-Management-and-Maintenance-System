<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Asset;
use App\Imports\AssetImport;

class AssetController extends Controller
{
    public function storeAssetFromExcel(Request $request)
{
    // ตรวจสอบเงื่อนไขและความถูกต้องของไฟล์ Excel ที่อัปโหลด
    $request->validate([
        'excel_file' => 'required|mimes:xls,xlsx'
    ]);

    // อ่านไฟล์ Excel
    $file = $request->file('excel_file');

    // นำเข้าข้อมูลจาก Excel
    Excel::import(new AssetImport, $file);

    // ดึงข้อมูลครุภัณฑ์ทั้งหมดจากฐานข้อมูล
    $assets = Asset::all();

    // ส่งกลับข้อความสำเร็จหลังจากนำเข้าข้อมูลเรียบร้อยพร้อมกับข้อมูลที่นำเข้า
    return view('uploaded_assets', compact('assets'))->with('success', 'นำเข้าข้อมูลสำเร็จ');
}



// Controller
public function showAssets() {
    $assets = Asset::all();
    return view('your_view_name', compact('assets'));
}



}
