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

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }

    public function planBudget()
    {
        return $this->belongsTo(PlanBudget::class,'plan_budget_id');
    }
}
