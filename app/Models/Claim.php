<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Claim extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'participant_id',
        'ndis_number',
        'start_date',
        'end_date',
        'claim_reference',
        'approved_by',
        'participant_approved',
        'claim_type',
        'cancellation_reason',
        'provider_abn',
        'invoice_number'
    ];

    //Claim type of the service provided
    const CLAIM_TYPE_CANC = 'CANC';
    const CLAIM_TYPE_REPW = 'REPW';
    const CLAIM_TYPE_TRAN = 'TRAN';
    const CLAIM_TYPE_NF2F = 'NF2F';
    const CLAIM_TYPES = [
        self::CLAIM_TYPE_CANC => 'Cancellation Charges',
        self::CLAIM_TYPE_REPW => 'Report Writing Charges',
        self::CLAIM_TYPE_TRAN => 'Travel Charges',
        self::CLAIM_TYPE_NF2F => 'Non-Face to Face Services',
    ];

    //GST information as applicable to the item or service.
    const TAX_TYPE_P1 = 'P1';
    const TAX_TYPE_P2 = 'P2';
    const TAX_TYPE_P3 = 'P3';
    const TAX_TYPES = [
        self::TAX_TYPE_P1 => 'Tax Claimable (10%)',
        self::TAX_TYPE_P2 => 'GST Free',
        self::TAX_TYPE_P3 => 'GST out of Scope',
    ];

    //Reason of the cancellation type
    const CANCELLATION_REASON_NSDH = 'NSDH';
    const CANCELLATION_REASON_NSDF = 'NSDF';
    const CANCELLATION_REASON_NSDT = 'NSDT';
    const CANCELLATION_REASON_NSDO = 'NSDO';
    const CANCELLATION_REASONS = [
        self::CANCELLATION_REASON_NSDH => 'No show due to health reason.',
        self::CANCELLATION_REASON_NSDF => 'No show due to family issues.',
        self::CANCELLATION_REASON_NSDT => 'No show due to unavailability of transport.',
        self::CANCELLATION_REASON_NSDO => 'Other.',
    ];

    public function setInvoiceNumberAttribute($value) {
        $this->attributes['claim_reference'] = $value;
    }

    /*
    |--------------------------------------------------------------------------
    | Model Local Scope queries defined below.
    |--------------------------------------------------------------------------
    */
    public function items() {
        return $this->hasMany(ClaimLineItem::class,'claim_id');
    }

    public function provider() {
        return $this->belongsTo(Provider::class,'provider_id');
    }

    public function participant() {
        return $this->belongsTo(Participant::class,'participant_id');
    }

    public static function getClaims() {
        return QueryBuilder::for(self::class)
                            ->with(['provider.user','participant.user','items']);
    }

}
