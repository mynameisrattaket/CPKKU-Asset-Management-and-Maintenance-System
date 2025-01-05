<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStatus extends Model
{
    use HasFactory;

    // ชื่อตารางที่ใช้ในฐานข้อมูล
    protected $table = 'asset_status';

    // Primary Key ของตาราง
    protected $primaryKey = 'asset_status_id';

    // ระบุประเภท Primary Key
    protected $keyType = 'int';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'asset_status_name', // ชื่อสถานะทรัพย์สิน
    ];

    // ความสัมพันธ์กับ AssetMain
    public function assets()
    {
        return $this->hasMany(AssetMain::class, 'asset_asset_status_id', 'asset_status_id');
    }
}
