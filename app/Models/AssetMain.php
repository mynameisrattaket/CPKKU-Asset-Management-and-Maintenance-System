<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMain extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asset_main'; // Table name
    protected $primaryKey = 'asset_id'; // Primary key

    protected $fillable = [
        'asset_number', 'asset_name', 'asset_budget', 'faculty_faculty_id',
        'asset_major', 'room_building_id', 'asset_location', 'room_room_id',
        'asset_comment', 'asset_asset_status_id', 'asset_brand', 'asset_price',
        'asset_fund', 'asset_reception_type', 'asset_regis_at', 'asset_created_at',
        'asset_plan', 'asset_project', 'asset_sn_number', 'asset_activity',
        'asset_deteriorated_total', 'asset_scrap_price', 'asset_deteriorated_account',
        'asset_deteriorated', 'asset_deteriorated_at', 'asset_deteriorated_stop',
        'asset_get', 'asset_document_number', 'asset_countingunit',
        'asset_deteriorated_price', 'asset_price_account', 'asset_account',
        'asset_deteriorated_total_account', 'asset_live', 'asset_deteriorated_end',
        'asset_code', 'asset_amount', 'asset_warranty_start', 'asset_warranty_end',
        'user_import_id', 'asset_detail', 'asset_plan', 'asset_project', 'asset_activity',
        'asset_location', 'asset_reception_type', 'asset_document_number',
        'asset_deteriorated_stop', 'asset_type', 'asset_comment', 'asset_how',
        'asset_company', 'asset_company_address', 'asset_type_sub', 'asset_type_main',
        'asset_revenue', 'asset_img', 'room_floor_id', 'room_building_id', 'faculty_faculty_id'
    ];

    protected $dates = [
        'asset_regis_at', 'asset_created_at', 'asset_deteriorated_at',
        'asset_deteriorated_end', 'asset_warranty_start', 'asset_warranty_end',
        'asset_deteriorated_stop', 'deleted_at'
    ];

    public function asset_status()
    {
        return $this->belongsTo(AssetStatus::class, 'asset_asset_status_id', 'asset_status_id');
    }

    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class, 'asset_id', 'asset_id');
    }
}
