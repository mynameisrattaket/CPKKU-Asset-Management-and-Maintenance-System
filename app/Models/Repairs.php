<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repairs extends Model
{
    use HasFactory;

    // ตั้งค่าชื่อของตาราง
    protected $table = 'repairs';

    // ตั้งค่าชื่อ primary key
    protected $primaryKey = 'id';

    // กำหนดให้ Eloquent รับข้อมูลในคอลัมน์เหล่านี้ได้
    protected $fillable = [
        'timestamp',
        'reporter_name',
        'asset_number',
        'asset_name',
        'symptom_detail',
        'location',
        'status',
        'note',
    ];

    // ตั้งค่าหมายเลข auto-increment
    public $incrementing = true;

    // ตั้งค่าให้ primary key เป็นชนิด integer ถ้าต้องการ
    protected $keyType = 'int';

    // ตั้งค่าให้ใช้ timestamps ของ Laravel
    public $timestamps = true;
}
