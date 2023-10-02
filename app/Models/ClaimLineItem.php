<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
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
        'rec_is_full_paid',
        'rec_payment_request_status',
        'rec_payment_request_number',
        'rec_capped_price',
        'rec_date',
        'old_claim_id',
        'auto_approval_process_counter',
        'auto_approval_status',
        'last_auto_approval_process_date'
    ];

    protected $appends = [
        'state',
        'can_changed'
    ];

    const STATUS_PENDING = 0;

    public function setItemNumberAttribute($value) {
        $this->attributes['support_item_number'] = $value;
    }

    public function getStateAttribute() {
        return Claim::STATS[$this->status];
    }

    public function setHoursAttribute($value)
    {
        $this->attributes['hours'] = round($value,2);
    }

    public function getHoursAttribute() {

        return round($this->attributes['hours'],2);
    }

    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = round($value,2);
    }

    public function getUnitPriceAttribute() {

        return round($this->attributes['unit_price'],2);
    }

    public function setAmountClaimedAttribute($value)
    {
        $this->attributes['amount_claimed'] = round($value,2);
    }

    public function getAmountClaimedAttribute() {

        return round($this->attributes['amount_claimed'],2);
    }


    public function setAmountPaidAttribute($value)
    {
        $this->attributes['amount_paid'] = round($value,2);
    }

    public function getAmountPaidAttribute() {

        return round($this->attributes['amount_paid'],2);
    }

    public function getClaimTypeProccesedAttribute() {
        if($this->attributes['claim_type'] == Claim::CLAIM_TYPE_F2F)
        {
            return '';
        }
        return $this->attributes['claim_type'];
    }

    public function getCanChangedAttribute() {
        if(in_array($this->status, [Claim::STATUS_APPROVAL_PENDING,Claim::STATUS_APPROVED_BY_REPRESENTATIVE, Claim::STATUS_DENIED_BY_REPRESENTATIVE])){
            return true;
        }
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Model Local Scope queries defined below.
    |--------------------------------------------------------------------------
    */
    public function claim() {
        return $this->belongsTo(Claim::class,'claim_id');
    }

    public function Service() {
        return $this->hasOne(Service::class,'support_item_number','support_item_number');
    }


    public static function getClaims() {
        return QueryBuilder::for(self::class)
            ->with(['claim','claim.provider.user','claim.participant.user','service'])
            ->allowedFilters([
                AllowedFilter::exact('claim_status', 'status'),
                AllowedFilter::exact('claim_type', 'claim_type'),
                AllowedFilter::partial('old_claim_ref', 'old_claim_ref'),
                AllowedFilter::partial('invoice_number', 'claim.claim_reference'),
                AllowedFilter::partial('provider_name', 'claim.provider.user.other_name'),
                AllowedFilter::partial('participant_name', 'claim.participant.user.other_name'),
                AllowedFilter::callback('claim_number', function (\Illuminate\Database\Eloquent\Builder $query, $claim_number){
                    $claimReference = '%'.$claim_number.'%';
                    $query->where(function (\Illuminate\Database\Eloquent\Builder $query) use ($claimReference){
                        $query->where('claim_reference','LIKE',$claimReference )
                            ->orWhere('old_claim_ref','LIKE',$claimReference );
                    });
                }),
            ]);
    }

}
