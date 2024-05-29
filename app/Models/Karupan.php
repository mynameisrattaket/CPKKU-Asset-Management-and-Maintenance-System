<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\asset_status;


use Illuminate\Database\Eloquent\SoftDeletes;

class Karupan extends Model
{

    use HasFactory, SoftDeletes;

    public function asset_main(){
        return $this->morphMany(asset_main::class, 'asset_maintable');
    }
    
    protected $table = 'asset_main';
    protected $primaryKey = 'asset_id'; // ระบุ primary key เป็น 'asset_id'
    protected $fillable = [ ' asset_name ', ' asset_price ', ' asset_regis_at ', ' asset_created_at ', ' asset_asset_status_id ', ' asset_comment ', ' asset_number ',
    'asset_plan',
    'asset_project',
    'asset_sn_number',
    'asset_activity',
    'asset_plan',
    'asset_budget',
    'asset_fund',
    'asset_major',
    'asset_location',
    'asset_reception_type',
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

    public function asset_status(){

        return $this->belongsTo(asset_status::class,'asset_asset_status_id');

    }
}











