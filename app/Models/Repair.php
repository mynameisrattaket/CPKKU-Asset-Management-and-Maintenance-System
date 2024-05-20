<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repair extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'request_detail';
    protected $primaryKey = 'request_detail_id'; // หากชื่อ primary key ไม่ใช่ 'id' ให้กำหนดให้ตรงกับ primary key ของตาราง
    protected $fillable = ['asset_number' , 'asset_name' , 'request_repair_id' , 'request_user_id' , 'request_user_type_id' , 'asset_symptom_detail' , 'location' , 'request_repair_note'];
}
