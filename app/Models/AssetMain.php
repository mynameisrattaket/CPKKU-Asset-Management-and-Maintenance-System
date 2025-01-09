<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMain extends Model
{
    use HasFactory;

    protected $table = 'asset_main'; // ชื่อตารางในฐานข้อมูล
    protected $primaryKey = 'asset_id'; // Primary Key

    protected $fillable = [
        'asset_number',
        'asset_name',
        'asset_budget',
        'faculty_faculty_id',
        'asset_major',
        'room_building_id',
        'asset_location',
        'room_room_id',
        'asset_comment',
        'asset_asset_status_id',
        'asset_brand',
        'asset_price',
        'asset_fund',
        'asset_reception_type',
    ];

    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'asset_id', 'asset_id');
    }
}
