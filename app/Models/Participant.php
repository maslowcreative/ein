<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
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
        'user_id',
        'representative_id',
        'relationship',
        'ndis_number',
        'dob',
    ];


    /**
     * Accessors
     */
    public function getIdAttribute()
    {
        return $this->user_id;
    }

    /**
     * Relationships
     */
    public function plans()
    {
        return $this->hasMany(Plan::class,'participant_id');
    }

    public function representative()
    {
        return $this->belongsTo(User::class,'representative_id');
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class,'provider_participant','participant_id','provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function items() {
        return $this->hasMany(ParticipantItems::class,'participant_id');
    }

}
