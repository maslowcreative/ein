<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderBudget extends Model
{
    use HasFactory;
    protected $table = 'provider_budget_allocation';
    protected $guarded = [];


    public function user() {
        return $this->belongsTo(User::class,'provider_id');
    }
}
