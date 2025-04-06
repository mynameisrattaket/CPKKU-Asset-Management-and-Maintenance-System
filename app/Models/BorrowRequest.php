<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'asset_id',
        'borrower_name',
        'borrow_date',
        'return_date',
        'status',
        'note',
        'location',
    ];

    

    public function asset()
    {
        return $this->belongsTo(AssetMain::class, 'asset_id', 'asset_id');
    }
}
