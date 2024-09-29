<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermain extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_status',
        'user_created_at',
        'user_update_at',
        'user_Last_login_at',
        'user_delete_at',
        'user_type',
        'user_type_id',
        'email_verified_at',
        'user_major'

    ];
}
