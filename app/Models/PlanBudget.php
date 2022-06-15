<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanBudget extends Model
{
    use HasFactory;
    protected $table = 'plan_budget';
    protected $guarded = [];


    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = round($value,2);
    }

    public function getAmountAttribute() {

        return round($this->amount,2);
    }
}
