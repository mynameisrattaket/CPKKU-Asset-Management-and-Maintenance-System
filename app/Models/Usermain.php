<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermain extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_first_name',
        'user_email',
        'user_password',
        'user_status',
        'user_created_at',
        'user_update_at',
        'user_Last_login_at',
        'user_delete_at',
        'user_type',
        'user_last_name',
        'faculty_faculty_id',
        'user_type_id',
        'user_major'

    ];
}
