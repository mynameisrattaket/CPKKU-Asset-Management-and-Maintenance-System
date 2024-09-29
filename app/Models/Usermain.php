<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usermain extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id';

    // หากไม่ใช้ timestamps อัตโนมัติให้ตั้งค่าเป็น false
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_status',
        'user_type',
        'user_type_id',
        'email_verified_at',
        'user_major'
    ];

    // แทนที่การบันทึกรหัสผ่านเพื่อทำการ Hash
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
