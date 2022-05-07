<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class User extends Authenticatable
{
    use HasFactory,HasRoles,Notifiable,SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATES = [
      'ACT',
      'NSW',
      'NT',
      'QLD',
      'SA',
      'TAS',
      'VIC',
      'WA',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'phone',
        'address',
        'status',
        'state',
        'temp_ndis_number',
        'bank_name',
        'account_number',
        'bsb_number'
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

    protected $appends =[
      'avatar_url'
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

    public function getAvatarUrlAttribute()
    {
        if($this->avatar){
            return asset("storage/avatars/{$this->avatar}");
        }
        return asset("images/avatar.png");
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
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

    public function plan()
    {
        return $this->hasOne(Plan::class,'participant_id');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class,'participant_id');
    }

    public static function getUsers()
    {
        return QueryBuilder::for(User::class)
            ->with(['roles'])
            ->allowedIncludes(['provider','provider.items','provider.participants','provider.participants.user','participant','participant.items','participant.representative','participant.providers','participant.providers.user','representative',])
            ->allowedFilters([
                AllowedFilter::exact('id', 'id'),
                AllowedFilter::partial('name', 'name'),
                AllowedFilter::exact('email', 'email'),
                AllowedFilter::exact('phone', 'phone'),
                AllowedFilter::callback('not_in',function (Builder $query,$ids){
                    $query->whereNotIn('id',$ids);
                }),
                AllowedFilter::callback('roles', function (Builder $query, $roles) {
                    $query->whereInRoles($roles);
                }),
                AllowedFilter::callback('plan_status', function (Builder $query, $plan_status) {
                    $query->whereHas('plans', function (Builder $query) use ($plan_status){
                        $query->whereIn('status',$plan_status);
                    });
                }),
                AllowedFilter::callback('participant_has_representative', function (Builder $query, $participant_has_representatives) {

                    $query->whereHas('participant', function (Builder $query) use ($participant_has_representatives){

                        if($participant_has_representatives) {
                            $query->whereNotNull('representative_id');
                        }

                        if(!$participant_has_representatives) {
                            $query->whereNull('representative_id');
                        }

                    });
                })
            ]);
    }

}
