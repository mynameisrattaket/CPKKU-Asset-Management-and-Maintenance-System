<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Karupan extends Model
{

    use HasFactory, SoftDeletes;

    public function asset_main(){
        return $this->morphMany(asset_main::class, 'asset_maintable');
    }
    
    protected $table = 'asset_main';
    protected $primarykey = 'asset_id';
    protected $fillable = [' asset_name ', ' asset_price ', ' asset_regis_at ', ' asset_created_at ', ' asset_status_id ', ' asset_comment ', ' asset_number ','updated_at','created_at',
    'asset_paln',
    'asset_project',
    'asset_activity',
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
    'asset_deteriorated_end',
    'delete_at'
    ];
}











