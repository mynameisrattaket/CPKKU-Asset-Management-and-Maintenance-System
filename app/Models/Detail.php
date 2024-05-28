<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Detail extends Model
{
    use HasFactory;

    protected $table = 'request_repair';
    protected $primaryKey = 'request_repair_id'; // หากชื่อ primary key ไม่ใช่ 'id' ให้กำหนดให้ตรงกับ primary key ของตาราง
    protected $fillable = ['repair_status_id' ,'request_repair_at' , 'user_user_id' , 'created_at' , 'updated_at'];

}

