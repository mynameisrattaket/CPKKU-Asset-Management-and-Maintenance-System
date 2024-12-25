<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMain extends Model
{
    use HasFactory;

    // ระบุชื่อของตารางที่เชื่อมโยงกับโมเดลนี้
    protected $table = 'asset_main'; // กรณีที่ตารางชื่อไม่ตรงกับชื่อโมเดล (ตามปกติ Laravel จะตั้งชื่อเป็นพหูพจน์)

    // ระบุคอลัมน์ที่สามารถกรอกข้อมูลได้ (ถ้าต้องการให้ Laravel รู้ว่าเราจะกรอกข้อมูลในคอลัมน์ไหน)
    protected $fillable = [
        'asset_number', // หมายเลขครุภัณฑ์
        'asset_name',   // ชื่อครุภัณฑ์
        // เพิ่มฟิลด์อื่นๆ ที่จำเป็น เช่น สถานะ, วันที่ซื้อ, หรือข้อมูลเพิ่มเติม
    ];

    // ถ้าต้องการกำหนดประเภทของฟิลด์ให้ Laravel รู้ว่าเป็นประเภทใด (ไม่ใช่ปกติทั้งหมด)
    // protected $casts = [
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];
}
