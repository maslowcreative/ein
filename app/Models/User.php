<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class User extends Authenticatable
{
    use HasFactory,HasRoles,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Accessors
     */

    public function getRoleAttribute()
    {
        return $this->roles()
                    ->select('id','name')
                    ->first()
                    ->makeHidden('pivot');
    }

    /*
   |--------------------------------------------------------------------------
   | Model Local Scope queries defined below.
   |--------------------------------------------------------------------------
   */

    public function scopewhereNotInRoles($query, $roles = [])
    {
       return $query->whereHas('roles',function ($query) use ($roles){
               $query->whereNotIn('name',$roles);
             });
    }

    public function scopewhereInRoles($query, $roles = [])
    {
        return $query->whereHas('roles',function ($query) use ($roles){
            $query->whereIn('name',$roles);
        });
    }

    /**
     * Relationships
     */
    public function provider()
    {
        return $this->hasOne(Provider::class,'user_id');
    }

    public function participant()
    {
        return $this->hasOne(Participant::class,'user_id');
    }

    public function representative()
    {
        return $this->hasOne(Representative::class,'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class,'user_id');
    }

    public static function getUsers()
    {
        return QueryBuilder::for(User::class)
            ->with(['roles'])
            ->allowedFilters([
                AllowedFilter::exact('id', 'id'),
                AllowedFilter::exact('email', 'email'),
                AllowedFilter::exact('phone', 'phone')
            ]);
    }

}
