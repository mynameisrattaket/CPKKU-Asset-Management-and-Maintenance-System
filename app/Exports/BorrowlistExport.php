<?php

namespace App\Exports;

use App\Models\BorrowRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BorrowlistExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BorrowRequest::all()->map(function ($borrow) {
            return [
                'รหัสคำร้อง' => $borrow->id,
                'ชื่อผู้ยืม' => $borrow->borrower_name,
                'สถานที่ยืม' => $borrow->location,
                'วันที่ขอยืม' => $borrow->borrow_date ? $borrow->borrow_date->format('d/m/Y') : '-',
                'วันที่คืน' => $borrow->return_date ? $borrow->return_date->format('d/m/Y') : '-',
                'สถานะ' => $this->getStatus($borrow->status),
                'หมายเหตุ' => $borrow->note,
            ];
        });
    }

    // ฟังก์ชันแปลงค่าของสถานะ
    private function getStatus($status)
    {
        switch ($status) {
            case 'pending':
                return 'รอดำเนินการ';
            case 'approved':
                return 'อนุมัติ';
            case 'rejected':
                return 'ถูกปฏิเสธ';
            case 'completed':
                return 'คืนแล้ว';
            default:
                return 'ไม่ทราบสถานะ';
        }
    }

    public function headings(): array
    {
        return [
            'รหัสคำร้อง', 'ชื่อผู้ยืม', 'สถานที่ยืม', 'วันที่ขอยืม', 'วันที่คืน', 'สถานะ', 'หมายเหตุ'
        ];
    }
}
