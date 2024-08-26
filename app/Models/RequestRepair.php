<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestRepair extends Model
{
    protected $table = 'request_repair';

    protected $primaryKey = 'request_repair_id';

    protected $fillable = [
        'request_repair_at',
        'repair_status_id',
        'user_user_id',
        'technician_id',
        'update_status_at',
        'created_at',
        'updated_at',
    ];

    public function repairStatus()
    {
        return $this->belongsTo(RepairStatus::class, 'repair_status_id', 'repair_status_id');
    }

    // Relationships, accessors, mutators, etc. can be defined here
}
