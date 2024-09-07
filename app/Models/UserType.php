<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'user_type'; // ชื่อของตารางในฐานข้อมูล

    protected $primaryKey = 'user_type_id'; // ชื่อของ primary key ของตาราง

    public $timestamps = false; // หากตารางของคุณไม่มีคอลัมน์ timestamps ให้ตั้งค่าเป็น false

    // กำหนด attributes ที่สามารถ fill ได้ (optional)
    protected $fillable = ['user_type_name'];
}
