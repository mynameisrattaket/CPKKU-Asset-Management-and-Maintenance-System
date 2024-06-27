<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'request_detail';
    protected $primaryKey = 'request_detail_id';
    protected $fillable = [
        'asset_number',
        'asset_name',
        'request_repair_id',
        'asset_symptom_detail',
        'location',
        'request_repair_note'
    ];
}
