<?php

namespace App\Models; // หรือ App หากใช้ Laravel รุ่นเก่ากว่า

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user'; // ตั้งชื่อ table ที่จะใช้ในฐานข้อมูล

    protected $primaryKey = 'id'; // กำหนด primary key

    protected $fillable = [
        'name',                 // ชื่อของผู้ใช้
        'email',                // อีเมลของผู้ใช้
        'password',             // รหัสผ่านของผู้ใช้
        'remember_token',       // Token สำหรับ "จดจำฉัน"
        'email_verified_at',    // วันที่ยืนยันอีเมล
        'created_at',           // วันที่สร้างผู้ใช้
        'updated_at',           // วันที่อัปเดตผู้ใช้
        'user_status',
        'user_created_at',
        'user_update_at',
        'user_Last_login_at',
        'user_delete_at',
        'user_type',
        'user_type_id',
        'user_major',

    ];

    protected $hidden = [
        'password',             // ซ่อนรหัสผ่าน
        'remember_token',       // ซ่อน remember_token
    ];

    protected $casts = [
        'email_verified_at' => 'datetime', // แปลงวันที่เป็น datetime
        'created_at' => 'datetime',         // แปลงวันที่เป็น datetime
        'updated_at' => 'datetime',         // แปลงวันที่เป็น datetime
    ];

    // ฟังก์ชันเพิ่มเติมตามที่คุณต้องการ
}
