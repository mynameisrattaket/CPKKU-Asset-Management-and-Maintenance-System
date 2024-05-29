<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asset_status extends Model
{
    use HasFactory;

    protected $table = 'asset_status';
    protected $primarykey = 'asset_status_id';
    protected $fillable = 'asset_status_name';

    public function Karupan()
    {
        return $this->hasMany(Karupan::class, 'asset_asset_status_id');
    }
}
