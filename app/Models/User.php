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

    protected $primaryKey = 'user_id'; // กำหนด primary key

    protected $fillable = [
        'user_first_name',
        'user_last_name',
        'user_email',
        'user_password',
        'user_status',
        'user_created_at',
        'user_update_at',
        'user_last_login_at',
        'user_delete_at',
        'user_type_id',
        'faculty_faculty_id',
        'user_major',
    ];

    protected $hidden = [
        'user_password', // ซ่อนรหัสผ่าน
        'remember_token',
    ];

    protected $casts = [
        'user_created_at' => 'datetime',
        'user_update_at' => 'datetime',
        'user_last_login_at' => 'datetime',
        'user_delete_at' => 'datetime',
    ];

    // ฟังก์ชันเพิ่มเติมตามที่คุณต้องการ
}
