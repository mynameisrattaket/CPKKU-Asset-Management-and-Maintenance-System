<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use App\Models\RequestRepair;
use App\Models\RequestDetail;
use App\Models\Usermain;
use Illuminate\Support\Carbon;

class GoogleSheetController extends Controller
{
    protected $sheetService;

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;
    }

    public function importData()
    {
        // ใส่ Spreadsheet ID ของ Google Sheet ของคุณ
        $spreadsheetId = '1vRA4JiIvbzipooeNQEkqD3mVEM-t42tWWLN1Iwe-WQgYKUI1HE5_ceECrWR3ra7qrf1Jxt-S67pYw6G';
        $range = 'Sheet1!A2:J';  // กำหนดช่วงข้อมูลที่ต้องการดึง

        // ดึงข้อมูลจาก Google Sheet
        $data = $this->sheetService->getSheetData($spreadsheetId, $range);

        // ลูปข้อมูลที่ได้จาก Google Sheet
        foreach ($data as $row) {
            $timestamp = Carbon::parse($row[0]);  // ประทับเวลา
            $reporterName = $row[1];  // ชื่อผู้แจ้ง
            $assetNumber = $row[2];  // หมายเลขเครื่อง
            $assetName = $row[3];  // อุปกรณ์ที่แจ้งซ่อม
            $symptomDetail = $row[4];  // อาการเบื้องต้น
            $location = $row[5];  // สถานที่
            $status = $row[6];  // สถานะ
            $updatedAt = Carbon::parse($row[7]);  // วันเวลาในการดำเนินการ
            $note = $row[8];  // หมายเหตุ

            // ค้นหาผู้แจ้งในฐานข้อมูลจากชื่อ
            $user = Usermain::where('user_first_name', $reporterName)->first();
            $userId = $user ? $user->user_id : null;

            // เช็คว่ามีหมายเลขเครื่องนี้ในฐานข้อมูลหรือไม่
            $requestDetail = RequestDetail::where('asset_number', $assetNumber)->first();

            if ($requestDetail) {
                // อัปเดตหรือสร้างข้อมูลใน request_repair
                RequestRepair::updateOrCreate(
                    ['request_repair_at' => $timestamp],
                    [
                        'user_user_id' => $userId,
                        'repair_status_id' => $status,
                        'updated_at' => $updatedAt,
                    ]
                );

                // อัปเดตข้อมูลใน request_detail
                $requestDetail->update([
                    'asset_name' => $assetName,
                    'asset_symptom_detail' => $symptomDetail,
                    'location' => $location,
                    'request_repair_note' => $note,
                ]);
            }
        }

        return "Import สำเร็จ!";
    }
}
