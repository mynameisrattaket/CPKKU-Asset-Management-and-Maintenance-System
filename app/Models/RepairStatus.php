<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairStatus extends Model
{
    protected $table = 'repair_status';
    protected $primaryKey = 'repair_status_id';

    // Define the relationship with RequestRepair model
    public function requestRepairs()
    {
        return $this->hasMany(RequestRepair::class, 'repair_status_id', 'repair_status_id');
    }
}
