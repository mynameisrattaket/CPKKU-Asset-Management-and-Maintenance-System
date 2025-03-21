<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\AssetMain;

class DataController extends Controller
{
    public function showImportPage()
    {
        return view('karupan/import');
    }

    public function saveData(Request $request)
    {
        try {
            if ($request->hasFile('excel_file')) {
                $excel = $request->file('excel_file');
                $reader = new Xlsx();
                $spreadsheet = $reader->load($excel->getPathname());
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                $headerRow = array_shift($sheetData); // Extract header row
                $mapping = [
                    "หมายเลขครุภัณฑ์" => "asset_number",
                    "ชื่อครุภัณฑ์" => "asset_name",
                    "ปีงบประมาณ" => "asset_budget",
                    "หน่วยงาน" => "faculty_faculty_id",
                    "ชื่อหน่วยงาน" => "asset_major",
                    "หน่วยงานย่อย" => "room_building_id",
                    "ชื่อหน่วยงานย่อย" => "asset_location",
                    "ใช้ประจำที่" => "room_room_id",
                    "ผลการตรวจสอบครุภัณฑ์" => "asset_comment",
                    "ตรวจสอบการใช้งาน" => "asset_asset_status_id",
                    "ยี่ห้อ ชนิดแบบขนาดหมายเลขเครื่อง" => "asset_brand",
                    "ราคาต่อหน่วย" => "asset_price",
                    "แหล่งเงิน" => "asset_fund",
                    "วิธีการได้มา" => "asset_reception_type",
                ];

                foreach ($sheetData as $row) {
                    $data = [];

                    foreach ($headerRow as $columnKey => $headerName) {
                        if (isset($mapping[$headerName]) && isset($row[$columnKey])) {
                            $data[$mapping[$headerName]] = $row[$columnKey];
                        }
                    }

                    // ตรวจสอบว่า asset_number ซ้ำในฐานข้อมูลหรือไม่
                    $existingAsset = AssetMain::where('asset_number', $data['asset_number'])->exists();
                    if ($existingAsset) {
                        // หากพบว่า asset_number ซ้ำ ให้แสดงแจ้งเตือน
                        return redirect()->route('import-excel')->with('error', 'หมายเลขครุภัณฑ์ ' . $data['asset_number'] . ' ซ้ำในฐานข้อมูล!');
                    }

                    // ถ้าไม่มีข้อมูลซ้ำ ให้บันทึกข้อมูล
                    AssetMain::create($data);
                }

                return redirect()->route('import-excel')->with('success', 'บันทึกข้อมูลลงฐานข้อมูลสำเร็จ!');
            } else {
                return redirect()->route('import-excel')->with('error', 'No file uploaded');
            }
        } catch (\Exception $e) {
            return redirect()->route('import-excel')->with('error', 'Error: ' . $e->getMessage());
        }
    }


}
