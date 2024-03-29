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
        'claim_reference',
        'invoice_path',
        'ndis_number',
        'start_date',
        'end_date',
        'authorised_by',
        'participant_approved',
        'representative_approved',
        'admin_approved',
        'provider_abn',
        'status',
        'rejection_reason',
        //Mutator
        'invoice_number',
        'old_claim_id',
        'admin_id'
    ];
    protected $appends = [
      'invoice_url',
      'state'
    ];


    //Claim type of the service provided
    const CLAIM_TYPE_NA = '';
    const CLAIM_TYPE_CANC = 'CANC';
    const CLAIM_TYPE_REPW = 'REPW';
    const CLAIM_TYPE_TRAN = 'TRAN';
    const CLAIM_TYPE_NF2F = 'NF2F';
    const CLAIM_TYPE_F2F = 'F2F';
    const CLAIM_TYPE_THLT = 'THLT';
    const CLAIM_TYPE_IRSS = 'IRSS';


    const CLAIM_TYPES = [
        self::CLAIM_TYPE_NA => 'N/A',
        self::CLAIM_TYPE_F2F => 'Face-To-Face',
        self::CLAIM_TYPE_CANC => 'Cancellation Charges',
        self::CLAIM_TYPE_REPW => 'Report Writing Charges',
        self::CLAIM_TYPE_TRAN => 'Travel Charges',
        self::CLAIM_TYPE_NF2F => 'Non-Face to Face Services',
        self::CLAIM_TYPE_THLT => 'Telehealth',
        self::CLAIM_TYPE_IRSS => 'Irregular SIL Supports',
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

    //Claim Status
    const STATUS_APPROVAL_PENDING = 0;
    const STATUS_APPROVED_BY_REPRESENTATIVE = 1;
    const STATUS_DENIED_BY_REPRESENTATIVE = 2;
    const STATUS_APPROVED_BY_ADMIN = 3;
    const STATUS_PROCESSED = 4;
    const STATUS_RECONCILATION_DONE = 5;
    const STATUS_CANCEL = 6;

    const STATS = [
        self::STATUS_APPROVAL_PENDING => 'Pending',
        self::STATUS_APPROVED_BY_REPRESENTATIVE => 'Accepted',
        self::STATUS_DENIED_BY_REPRESENTATIVE => 'Rejected',
        self::STATUS_APPROVED_BY_ADMIN => 'Approved',
        self::STATUS_PROCESSED => 'Processing',
        self::STATUS_RECONCILATION_DONE => 'Reconciled',
        self::STATUS_CANCEL => 'Canceled',
    ];



    public function setInvoiceNumberAttribute($value) {
        $this->attributes['claim_reference'] = $value;
    }

    public function getInvoiceUrlAttribute() {
        return route('claim.invoice.download',['claim'=> $this->id ]);
    }

    public function getStateAttribute() {
        return self::STATS[$this->status];
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
                            ->with(['provider.user','participant.user','items'])
                            ->allowedFilters([
                                AllowedFilter::exact('claim_status', 'status'),
                            ]);
    }

}
