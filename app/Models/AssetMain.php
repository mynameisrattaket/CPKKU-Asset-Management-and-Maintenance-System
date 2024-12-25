<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMain extends Model
{
    use HasFactory;

    // ตารางที่เชื่อมโยง
    protected $table = 'asset_main';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'asset_number',         // หมายเลขครุภัณฑ์
        'asset_name',           // ชื่อครุภัณฑ์
        'asset_budget',         // ปีงบประมาณ
        'faculty_faculty_id',   // หน่วยงาน
        'asset_major',          // ชื่อหน่วยงาน
        'room_building_id',     // หน่วยงานย่อย
        'asset_location',       // ชื่อหน่วยงานย่อย
        'room_room_id',         // ใช้ประจำที่
        'asset_comment',        // ผลการตรวจสอบครุภัณฑ์
        'asset_asset_status_id',// ตรวจสอบการใช้งาน
        'asset_brand',          // ยี่ห้อ ชนิดแบบขนาดหมายเลขเครื่อง
        'asset_price',          // ราคาต่อหน่วย
        'asset_fund',           // แหล่งเงิน
        'asset_reception_type', // วิธีการได้มา
    ];

    // การแปลงประเภทข้อมูล (Casting)
    protected $casts = [
        'asset_price' => 'float',       // ราคาต่อหน่วยเป็น float
        'asset_budget' => 'integer',   // ปีงบประมาณเป็น integer
    ];
}
