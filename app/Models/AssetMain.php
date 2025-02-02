<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMain extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asset_main'; // ชื่อตาราง
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
        'asset_regis_at',
        'asset_created_at',
        'asset_plan',
        'asset_project',
        'asset_sn_number',
        'asset_activity',
        'asset_deteriorated_total',
        'asset_scrap_price',
        'asset_deteriorated_account',
        'asset_deteriorated',
        'asset_deteriorated_at',
        'asset_deteriorated_stop',
        'asset_get',
        'asset_document_number',
        'asset_countingunit',
        'asset_deteriorated_price',
        'asset_price_account',
        'asset_account',
        'asset_deteriorated_total_account',
        'asset_live',
        'asset_deteriorated_end'
    ];

    protected $dates = ['asset_regis_at'];

    public function asset_status()
    {
        return $this->belongsTo(AssetStatus::class, 'asset_asset_status_id', 'asset_status_id');
    }

    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'asset_id', 'asset_id');
    }
}
