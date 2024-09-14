<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Laravel Google Sheets Integration');
        $this->client->setScopes([Sheets::SPREADSHEETS_READONLY]);
        $this->client->setDeveloperKey('AIzaSyCwIBXiNCPhP0vtidAAsi9FzOb-MLNXS_4'); // API Key ของคุณ

        $this->service = new Sheets($this->client);
    }

    public function getSheetData($spreadsheetId, $range)
    {
        try {
            $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) {
                Log::warning('ไม่มีข้อมูลใน Google Sheets หรือช่วงข้อมูลไม่ถูกต้อง');
            } else {
                Log::info('ข้อมูลที่ได้รับจาก Google Sheets: ' . json_encode($values));
            }

            return $values;
        } catch (\Exception $e) {
            Log::error('เกิดข้อผิดพลาดในการดึงข้อมูลจาก Google Sheets: ' . $e->getMessage());
            return null;  // คืนค่า null ถ้ามีข้อผิดพลาด
        }
    }
}
