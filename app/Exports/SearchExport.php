<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SearchExport implements FromCollection, WithHeadings
{
    protected $assets;

    // รับข้อมูลที่กรองมาจาก Controller
    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    // ดึงข้อมูลที่กรองมาจาก Controller
    public function collection()
    {
        return collect($this->assets)->map(function ($asset) {
            return [
                'รหัส' => $asset->asset_id,  // รหัส
                'หมายเลขครุภัณฑ์' => $asset->asset_number,  // หมายเลขครุภัณฑ์
                'ชื่อครุภัณฑ์' => $asset->asset_name,  // ชื่อครุภัณฑ์
                'ราคาต่อหน่วย' => $asset->asset_price,  // ราคาต่อหน่วย
                'ยี่ห้อ' => $asset->asset_brand,  // ยี่ห้อ
                'ปีงบประมาณ' => $asset->asset_budget,  // ปีงบประมาณ
                'แหล่งเงิน' => $asset->asset_fund,  // แหล่งเงิน
                'สถานที่' => $asset->asset_location,  // สถานที่
                'วิธีการได้มา' => $asset->asset_reception_type,  // วิธีการได้มา
                'สถานะ' => $this->getAssetStatus($asset->asset_asset_status_id),  // สถานะ
            ];
        });
    }

    // ฟังก์ชันแปลงค่าของสถานะ
    private function getAssetStatus($statusId)
    {
        switch ($statusId) {
            case 1:
                return 'พร้อมใช้งาน';
            case 2:
                return 'กำลังถูกยืม';
            case 3:
                return 'ชำรุด';
            case 4:
                return 'กำลังซ่อม';
            case 5:
                return 'จำหน่าย';
            default:
                return 'ไม่ทราบสถานะ';
        }
    }

    // กำหนดหัวข้อของข้อมูลใน Excel
    public function headings(): array
    {
        return [
            'รหัส', 'หมายเลขครุภัณฑ์', 'ชื่อครุภัณฑ์', 'ราคาต่อหน่วย', 'ยี่ห้อ',  'ปีงบประมาณ',
            'แหล่งเงิน', 'สถานที่', 'วิธีการได้มา','สถานะ',
        ];
    }
}
