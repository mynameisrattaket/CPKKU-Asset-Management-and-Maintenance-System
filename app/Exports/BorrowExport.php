<?php

namespace App\Exports;

use App\Models\BorrowRequest;
use App\Models\AssetMain;  // เพิ่มการใช้ AssetMain
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;  // ใช้สำหรับการแปลงวันที่

class BorrowExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return BorrowRequest::select(
            'id', 'asset_id', 'borrower_name', 'borrow_date',
            'return_date', 'location', 'note', 'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ไอดี', 'หมายเลขครุภัณฑ์', 'ชื่อครุภัณฑ์', 'ชื่อผู้ขอยืม',
            'วันที่ยืม', 'วันที่คืน', 'สถานที่', 'หมายเหตุ', 'สถานะ'
        ];
    }

    public function map($borrowRequest): array
    {
        // ดึงข้อมูลของ asset จาก asset_main
        $asset = AssetMain::find($borrowRequest->asset_id);

        return [
            $borrowRequest->id,  // รหัสคำขอยืม
            $asset ? $asset->asset_number : 'ไม่มีข้อมูล', // หมายเลขครุภัณฑ์
            $asset ? $asset->asset_name : 'ไม่มีข้อมูล',  // ชื่อครุภัณฑ์
            $borrowRequest->borrower_name,  // ชื่อผู้ขอยืม
            Carbon::parse($borrowRequest->borrow_date)->format('d/m/Y'),  // วันที่ยืม (รูปแบบวันเดือนปี)
            Carbon::parse($borrowRequest->return_date)->format('d/m/Y'),  // วันที่คืน (รูปแบบวันเดือนปี)
            $borrowRequest->location,  // สถานที่
            $borrowRequest->note,  // หมายเหตุ
            $this->getStatusText($borrowRequest->status),  // สถานะ
        ];
    }

    private function getStatusText($status)
    {
        return match ($status) {
            'pending' => 'รอดำเนินการ',
            'approved' => 'อนุมัติ',
            'completed' => 'คืนแล้ว',
            'rejected' => 'ถูกปฏิเสธ',
            default => 'ไม่ระบุ',
        };
    }
}



