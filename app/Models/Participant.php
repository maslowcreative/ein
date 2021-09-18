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
        'representative_id',
        'unique_identifier',
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

}
