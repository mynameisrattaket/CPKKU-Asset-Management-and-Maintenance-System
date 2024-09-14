<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Log;

class GoogleSheetController extends Controller
{
    protected $sheetService;

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;
    }



    public function showSheetData()
    {
        $spreadsheetId = '2PACX-1vQBaZaVhDzkCCI2YEDh4D9dIpSdj5wCMlFxqgmOJkYDeGimH6trXnSkVdtO0Rvt-41QmHGwhcvYzKzO'; // เปลี่ยนเป็น ID ของ Google Sheets
        $range = 'Sheet1!A1:E10';  // เปลี่ยนเป็นช่วงข้อมูลที่คุณต้องการดึง

        try {
            $response = $this->sheetService->getSheetData($spreadsheetId, $range);
            $values = $response;

            if (empty($values)) {
                Log::warning('ข้อมูลใน Google Sheets เป็นว่างเปล่าหรือช่วงข้อมูลไม่ถูกต้อง');
                return 'ข้อมูลใน Google Sheets เป็นว่างเปล่าหรือช่วงข้อมูลไม่ถูกต้อง';
            }

            return view('import-sheet', ['data' => $values]);
        } catch (\Exception $e) {
            Log::error('เกิดข้อผิดพลาดในการดึงข้อมูลจาก Google Sheets: ' . $e->getMessage());
            return 'เกิดข้อผิดพลาดในการดึงข้อมูลจาก Google Sheets';
        }
    }




}
