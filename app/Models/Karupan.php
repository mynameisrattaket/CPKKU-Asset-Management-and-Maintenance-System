<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karupan extends Model
{

    use HasFactory;

    public function asset_main(){
        return $this->morphMany(asset_main::class, 'asset_maintable');
    }
    
    protected $table = 'asset_main';
    protected $primarykey = 'asset_id';
    protected $fillable = [' asset_name ', ' asset_price ', ' asset_regis_at ', ' asset_created_at ', ' asset_status_id ', ' asset_comment ', ' asset_number ','updated_at','created_at',
    // 'asset_paln',
    // 'asset_project',
    // 'asset_activity',
    // 'asset_baget',
    // 'asset_fund',
    // 'asset_faculty',
    // 'asset_major',
    // 'asset_location',
    // 'asset_reception_type',
    // 'deteriorated_total',
    // 'scrap_price',
    // 'deteriorated_account',
    // 'deteriorated',
    // 'deteriorated_at',
    // 'asset_deteriorated_stop',
    // 'asset_get',
    // 'asset_status',
    // 'asset_document_number',
    // 'asset_countingunit',
    // 'deteriorated_price',
    // 'asset_price_account',
    // 'asset_account',
    // 'deteriorated_total_account',
    // 'asset_live',
    // 'deteriorated_end'
    ];
}











