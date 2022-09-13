<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = [
        'start_date_formatted',
        'end_date_formatted'
    ];

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }

    public function setBudgetAttribute($value)
    {
        $this->attributes['budget'] = round($value,2);
    }

    public function getBudgetAttribute() {

        return round($this->attributes['budget'],2);
    }

    public function getStartDateFormattedAttribute()
    {
        return Carbon::parse($this->start_date)->format('d/m/y');
    }

    public function getEndDateFormattedAttribute()
    {
        return Carbon::parse($this->end_date)->format('d/m/y');
    }

    public function budgets(){
        return $this->hasMany(PlanBudget::class,'plan_id');
    }
}
