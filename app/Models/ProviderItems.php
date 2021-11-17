<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderItems extends Model
{
    use HasFactory;
    protected $table = "provider_items";

    protected $fillable = ['provider_id','item_number','created_at','updated_at'];
}
