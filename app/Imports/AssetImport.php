<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Asset;

class AssetImport implements ToModel
{
    public function model(array $row)
    {
        return new Asset([
            // กำหนดค่าสำหรับแต่ละคอลัมน์ของข้อมูล
            'column_name_1' => $row[0],
            'column_name_2' => $row[1],
            // เพิ่มคอลัมน์ต่อไปตามลำดับ
        ]);
    }
}
