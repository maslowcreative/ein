<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $primaryKey = "support_item_number";
    public $incrementing = false;

    /**
     * Relationships
     */
    public static function getServices()
    {
        return QueryBuilder::for(Service::class)
                ->allowedFilters([
                    AllowedFilter::partial('item_number','support_item_number')
                ]);
    }
}
