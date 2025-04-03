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
            // ตรวจสอบว่าไฟล์ที่อัพโหลดเป็นไฟล์ .xlsx หรือไม่
            if ($request->hasFile('excel_file')) {
                $excel = $request->file('excel_file');

                // ตรวจสอบนามสกุลไฟล์
                if ($excel->getClientOriginalExtension() != 'xlsx') {
                    return redirect()->route('import-excel')->with('error', 'โปรดอัพโหลดไฟล์ Excel (.xlsx) เท่านั้น');
                }

                // อ่านไฟล์ Excel
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
                    "ยี่ห้อ ชนิดแบบขนาดหมายเลขเครื่อง" => "asset_brand",
                    "ราคาต่อหน่วย" => "asset_price",
                    "แหล่งเงิน" => "asset_fund",
                    "วิธีการได้มา" => "asset_reception_type",
                    "สถานะ" => "asset_asset_status_id",
                ];

                // ตรวจสอบหัวคอลัมน์ว่ามีครบถ้วนตามที่ต้องการหรือไม่
                $missingColumns = array_diff(array_keys($mapping), $headerRow);
                if (!empty($missingColumns)) {
                    return redirect()->route('import-excel')->with('error', 'หัวคอลัมน์ที่ขาด: ' . implode(', ', $missingColumns));
                }

                // ตรวจสอบหัวคอลัมน์เกิน
                if (count($headerRow) > count($mapping)) {
                    return redirect()->route('import-excel')->with('error', 'ไม่สามารถอัพโหลดไฟล์ได้เนื่องจากมีหัวคอลัมน์เกิน');
                }

                // ตรวจสอบหัวคอลัมน์ซ้ำ
                $headerCounts = array_count_values($headerRow);
                $duplicateHeaders = array_filter($headerCounts, function ($count) {
                    return $count > 1;
                });

                if (!empty($duplicateHeaders)) {
                    return redirect()->route('import-excel')->with('error', 'ไม่สามารถอัพโหลดไฟล์ได้เนื่องจากมีหัวคอลัมน์ซ้ำ: ' . implode(', ', array_keys($duplicateHeaders)));
                }

                // แปลงข้อมูลจากไฟล์ Excel
                $assetsToInsert = [];
                foreach ($sheetData as $row) {
                    $data = [];

                    foreach ($headerRow as $columnKey => $headerName) {
                        if (isset($mapping[$headerName]) && isset($row[$columnKey])) {
                            $data[$mapping[$headerName]] = $row[$columnKey];
                        }
                    }

                    // กำหนดค่า "asset_asset_status_id" เป็น 1 ทุกแถว
                    $data['asset_asset_status_id'] = 1;

                    // ตรวจสอบว่า asset_number ซ้ำในฐานข้อมูลหรือไม่
                    $existingAsset = AssetMain::where('asset_number', $data['asset_number'])->exists();
                    if ($existingAsset) {
                        return redirect()->route('import-excel')->with('error', 'หมายเลขครุภัณฑ์ ' . $data['asset_number'] . ' ซ้ำในฐานข้อมูล!');
                    }

                    $assetsToInsert[] = $data;
                }

                // บันทึกข้อมูลทั้งหมดที่ตรวจสอบแล้ว
                if (!empty($assetsToInsert)) {
                    AssetMain::insert($assetsToInsert);
                    return redirect()->route('import-excel')->with('success', 'บันทึกข้อมูลลงฐานข้อมูลสำเร็จ!');
                }

                return redirect()->route('import-excel')->with('error', 'ไม่มีข้อมูลที่สามารถบันทึกได้');
            } else {
                return redirect()->route('import-excel')->with('error', 'ไม่พบไฟล์ที่อัพโหลด');
            }
        } catch (\Exception $e) {
            return redirect()->route('import-excel')->with('error', 'Error: ' . $e->getMessage());
        }
    }


}
