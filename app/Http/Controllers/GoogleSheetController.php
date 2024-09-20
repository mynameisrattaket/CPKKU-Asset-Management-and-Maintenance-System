<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Repair;

class GoogleSheetController extends Controller
{
    public function importDataFromSheet()
    {
        try {
            // ดึงค่า spreadsheet_id จาก config
            $spreadsheetId = config('google.spreadsheet_id');

            // ตรวจสอบว่า spreadsheetId ไม่เป็น null
            if (is_null($spreadsheetId)) {
                throw new \Exception('Google Spreadsheet ID is not set in config.');
            }

            // ดึงข้อมูลจาก Google Sheets
            $sheetData = Sheets::spreadsheet($spreadsheetId)
                ->sheet('Sheet1')   // ระบุชื่อ sheet หรือหมายเลข sheet ที่ต้องการ
                ->get();

            // กำหนดให้แถวแรกเป็น header (column names)
            $header = $sheetData->pull(0);

            // ลูปข้อมูลที่ได้จาก Google Sheets แล้วบันทึกลงในฐานข้อมูล
            foreach ($sheetData as $row) {
                if (count($row) >= 9) {
                    Repair::updateOrCreate(
                        ['asset_number' => $row[2]], // ใช้ asset_number เป็น unique key
                        [
                            'timestamp'       => $row[0],  // Timestamp
                            'reporter_name'   => $row[1],  // Reporter Name
                            'asset_name'      => $row[3],  // Asset Name
                            'symptom_detail'  => $row[4],  // Symptom Detail
                            'location'        => $row[5],  // Location
                            'status'          => $row[6],  // Status
                            'updated_at'      => $row[7],  // Updated At
                            'note'            => $row[8] ?? null,  // Note (nullable)
                        ]
                    );
                }
            }

            return response()->json(['message' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
