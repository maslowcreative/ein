<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
        'provider_id',
        'participant_id',
        'claim_reference',
        'support_item_number',
        'hours',
        'unit_price',
        'amount_claimed',
        'amount_paid',
        'gst_code',
        'claim_type',
        'cancellation_reason',
        'status',
    ];

    protected $appends = [
        'state'
    ];

    const STATUS_PENDING = 0;

    public function setItemNumberAttribute($value) {
        $this->attributes['support_item_number'] = $value;
    }

    public function getStateAttribute() {
        return Claim::STATS[$this->status];
    }

    /*
    |--------------------------------------------------------------------------
    | Model Local Scope queries defined below.
    |--------------------------------------------------------------------------
    */
    public function claim() {
        return $this->belongsTo(Claim::class,'claim_id');
    }


    public static function getClaims() {
        return QueryBuilder::for(self::class)
            ->with(['claim','claim.provider.user','claim.participant.user'])
            ->allowedFilters([
                AllowedFilter::exact('claim_status', 'status'),
                AllowedFilter::exact('claim_type', 'claim_type'),
            ]);
    }

}
