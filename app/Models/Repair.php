<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'request_detail';
    protected $primaryKey = 'id'; // หากชื่อ primary key ไม่ใช่ 'id' ให้กำหนดให้ตรงกับ primary key ของตาราง
    public $timestamps = false; // หากไม่มี created_at และ updated_at ในตาราง
}
