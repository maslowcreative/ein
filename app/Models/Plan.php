<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_name',
        'file_name',
        'participant_id',
        'start_date',
        'end_date',
        'budget',
        'charges_types',
        'status'
    ];

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }

    public function setBudgetAttribute($value)
    {
        $this->attributes['budget'] = round($value,2);
    }

    public function getBudgetAttribute() {

        return round($this->budget,2);
    }

    public function budgets(){
        return $this->hasMany(PlanBudget::class,'plan_id');
    }
}
