<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantItems extends Model
{
    use HasFactory;

    protected $table = "participant_items";

    protected $fillable = ['participant_id','item_number','created_at','updated_at'];
}
