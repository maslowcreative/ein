<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimLineItem extends Model
{
    use HasFactory;
    protected $table = 'claim_line_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_number',
        'claim_id',
        'support_item_number',
        'hours',
        'unit_price',
        'gst_code',
        'claim_type',
        'cancellation_reason'
    ];


    public function setItemNumberAttribute($value) {
        $this->attributes['support_item_number'] = $value;
    }
    /*
    |--------------------------------------------------------------------------
    | Model Local Scope queries defined below.
    |--------------------------------------------------------------------------
    */
    public function claim() {
        return $this->belongsTo(Claim::class,'claim_id');
    }

}
