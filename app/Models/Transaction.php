<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    const STATUS_PENDING = 0;
    const STATUS_SPENT = 1;
    const STATUS_REP_REJECTED = 2;
    const STATUS_RECO_FAILED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereIn('status',[
            self::STATUS_PENDING,
            self::STATUS_SPENT,
        ]);

    }

}
