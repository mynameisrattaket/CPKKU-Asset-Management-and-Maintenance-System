<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RepairExport implements FromCollection, WithHeadings
{
    protected $repairs;

    public function __construct($repairs)
    {
        $this->repairs = $repairs;
    }

    public function collection()
    {
        return $this->repairs;
    }

    public function headings(): array
    {
        return [
            'วันที่แจ้งซ่อม',
            'ชื่อ/ประเภทอุปกรณ์',
            'หมายเลขครุภัณฑ์',
            'รายละเอียดอาการเสีย',
            'สถานที่',
            'ชื่อผู้แจ้ง',
            'สถานะผู้แจ้ง',
            'สถานะการซ่อม',
            'บันทึกการซ่อม',
            'ช่างที่รับผิดชอบงาน',
            'วันที่ดำเนินการ'
        ];
    }
}

