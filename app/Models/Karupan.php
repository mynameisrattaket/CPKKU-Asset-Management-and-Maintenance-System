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
    protected $fillable = [' asset_name ', ' asset_price ', ' asset_regis_at ', ' asset_created_at ', ' asset_status_id ', ' asset_comment ', ' asset_number '];
}
