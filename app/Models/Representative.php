<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;

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
    public function participants()
    {
        return $this->hasMany(Participant::class,'representative_id');
    }
}
