<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abn',
        'business_name',
    ];

    /**
     * Accessors
     */

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    /**
     * Relationships
     */
    public function participants()
    {
        return $this->belongsToMany(Participant::class,'provider_participant','provider_id','participant_id');
    }

    public function claims() {
        return $this->hasMany(Claim::class,'provider_id');
    }
}
