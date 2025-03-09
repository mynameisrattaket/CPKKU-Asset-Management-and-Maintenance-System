<?php

namespace App\Exports;

use App\Models\BorrowRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return BorrowRequest::select(
            'id', 'asset_id', 'borrower_name', 'borrow_date',
            'return_date', 'location', 'note', 'status', 'created_at', 'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Asset ID', 'Borrower Name', 'Borrow Date',
            'Return Date', 'Location', 'Note', 'Status', 'Created At', 'Updated At'
        ];
    }

    public function map($borrowRequest): array
    {
        return [
            $borrowRequest->id,
            $borrowRequest->asset_id,
            $borrowRequest->borrower_name,
            $borrowRequest->borrow_date,
            $borrowRequest->return_date,
            $borrowRequest->location,
            $borrowRequest->note,
            $this->getStatusText($borrowRequest->status), // เปลี่ยนสถานะ
            $borrowRequest->created_at,
            $borrowRequest->updated_at,
        ];
    }

    private function getStatusText($status)
    {
        return match ($status) {
            'pending' => 'รอดำเนินการ',
            'approved' => 'อนุมัติ',
            'completed' => 'คืนแล้ว',
            'rejected' => 'ถูกปฏิเสธ', // เพิ่ม rejected
            default => 'ไม่ระบุ',
        };
    }
}


