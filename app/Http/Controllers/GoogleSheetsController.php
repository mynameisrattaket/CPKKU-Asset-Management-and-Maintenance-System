<?php

namespace App\Http\Controllers;

use App\Models\SheetData;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;

class GoogleSheetsController extends Controller
{
    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function import()
    {
        $spreadsheetId = '1vRA4JiIvbzipooeNQEkqD3mVEM-t42tWWLN1Iwe-WQgYKUI1HE5_ceECrWR3ra7qrf1Jxt-S67pYw6G';
        $range = 'Sheet1!A1:D10'; // เปลี่ยนเป็นช่วงข้อมูลที่คุณต้องการดึง

        $data = $this->googleSheetsService->getSheetData($spreadsheetId, $range);

        foreach ($data as $row) {
            SheetData::create([
                'column1' => $row[0] ?? null,
                'column2' => $row[1] ?? null,
                'column3' => $row[2] ?? null,
                'column4' => $row[3] ?? null,
            ]);
        }

        return response()->json(['message' => 'Data imported successfully!']);
    }
}
