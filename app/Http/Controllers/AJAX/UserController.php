<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Participant;
use App\Models\Provider;
use App\Models\ProviderItems;
use App\Models\Representative;
use App\Models\Role;
use App\Models\User;
use App\Traits\CreateUserTrait;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    use ApiResponseHelpers,CreateUserTrait;

    public function __construct()
    {
        $this->middleware('participant.email.replace')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getUsers()
                     ->whereNotInRoles(['admin','sub-admin']);

        if(Auth::user()->hasRole('admin')) {
            $users = $users->with('plan');
        }

        if(Auth::user()->hasRole('provider')) {
            $participantsIds = Auth::user()->provider->participants()->pluck('participant_id');
            $users = $users->whereIn('id',$participantsIds)->with('participant.representative');
        }

        if(Auth::user()->hasRole('representative')) {
            if(\request()->filter['roles'][0] == 'participant'){
                $participantIds = Auth::user()->representative->participants()->pluck('user_id');
                $users = $users->whereIn('id',$participantIds)->with('participant');
            }
            elseif (\request()->filter['roles'][0] == 'provider') {
                $providerIds = Auth::user()->representative->providers()->pluck('provider_id');
                $users = $users->whereIn('id',$providerIds);
            }
        }

        $users = $users->paginate(5);
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPostRequest $request, User $user)
    {
        DB::beginTransaction();

        $user = $this->create($request->all());
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role->name);

        //Provider Role:
        if(Role::ROLE_PROVIDER == $role->id) {
          $provider = $user->provider()->create($request->provider);
          if($request->provider['participants'] ?? false )
             $provider->participants()->attach($request->provider['participants'],['created_at' => now(),'updated_at'=> now()]);

          if($request->provider['items'] ?? false ){
              $items = [];
              foreach ($request->provider['items'] as $value) {
                  array_push($items,['item_number' =>$value,'provider_id'=>$provider->user_id]);
              }
              $provider->items()->createMany($items);
          }


        }
        //Participant Role:
        if(Role::ROLE_PARTICIPANT == $role->id) {

          $participant = $user->participant()->create($request->participant);

          if(ifEmptyReturnNull($request->participant['providers'])) {
              $participant->providers()->attach($request->participant['providers'],['created_at' => now(),'updated_at'=> now()]);
          }
          if($request->participant['items'] ?? false ){
            $items = [];
            foreach ($request->participant['items'] as $value) {
                array_push($items,['item_number' => $value,'participant_id'=> $participant->user_id]);
            }
            $participant->items()->createMany($items);

          }

          if($request->participant['plan'] ?? false)
            $plan = $participant->plans()->create($request->participant['plan']);
        }
        //Representative Role:
        if(Role::ROLE_REPRESENTATIVE == $role->id) {
          $representative = $user->representative()->create();

          if(ifEmptyReturnNull($request->representative['participants'])){
              foreach ($request->representative['participants'] as $participantsIdd)
              {
                Participant::find($participantsIdd)
                           ->fill(['representative_id' => $representative->id])
                           ->save();
              }
          }
        }

        //Admin:
        if(Role::ROLE_SUB_ADMIN == $role->id) {

            $permissions = collect($request->permissions)->filter(function ($value, $key) {
                return $value == true;
            })->keys();
            $admin = $user->admin()->create();
            $user->syncPermissions($permissions);
        }

        //Send Password Email:
        if(Role::ROLE_PARTICIPANT != $role->id)
            event(new Registered($user));

        DB::commit();
        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->respondCreated();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $userId)
    {
        $user = User::findOrFail($userId);

        DB::beginTransaction();
            $user->fill($request->all())->save();

            if($user->hasRole('provider') && $request->role_id == Role::ROLE_PROVIDER) {
                $user->provider->fill($request->provider)->save();
                $user->provider->participants()->sync($request->provider['participants']);

                $user->provider->items()->delete();
                $items = [];
                foreach ($request->provider['items'] as $value) {
                    array_push($items,['item_number' => $value,'provider_id'=> $user->provider->user_id]);
                }
                $user->provider->items()->createMany($items);
            }

            if($user->hasRole('participant') && $request->role_id == Role::ROLE_PARTICIPANT) {
                $user->participant->fill($request->participant)->save();
                $user->participant->providers()->sync($request->participant['providers']);

                $user->participant->items()->delete();
                $items = [];
                foreach ($request->participant['items'] as $value) {
                    array_push($items,['item_number' => $value,'participant_id'=> $user->participant->user_id]);
                }
                $user->participant->items()->createMany($items);

            }

            if($user->hasRole('representative') && $request->role_id == Role::ROLE_REPRESENTATIVE) {
                $user->representative->participants()->update(['representative_id'=> null]);
                if(ifEmptyReturnNull($request->representative['participants'])){
                    foreach ($request->representative['participants'] as $participantsId)
                    {
                        Participant::find($participantsId)
                            ->fill(['representative_id' => $user->id])
                            ->save();
                    }
                }
            }

        DB::commit();

        return $this->respondWithSuccess();
    }

    /**
     * Update the basic info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBasicInfo(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->hasRole('provider');

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'. $userId,
            'password' => 'sometimes|exclude_if:role_id,'.Role::ROLE_PARTICIPANT.'|required|string|confirmed',
            'phone' => 'sometimes|string|nullable',
            'address' => 'sometimes|string|nullable',

        ]);

        $user->fill($request->all())->save();

        return $this->respondWithSuccess();
    }

    /**
     * Update the Bank info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBankInfo(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if( !$user->hasAnyRole('provider','representative') ){
            return $this->respondForbidden();
        }

        $request->validate([
            'account_name' => 'string|required_with_all:account_number,bsb',
            'account_number' => 'string|required_with_all:account_name,bsb',
            'bsb' => 'string|required_with_all:account_name,account_number',
        ]);

        $user->fill($request->all())->save();

        return $this->respondWithSuccess();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasRole('admin')) {
            return $this->respondForbidden();
        }

        $user = User::findOrFail($id);
        $user->delete();
        return $this->respondWithSuccess();
    }

    /**
     * @param Representative $representative
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function repParticipants(Representative $representative)
    {
        return $representative->participants()->with('user')->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Request $request)
    {
        if(!Auth::user()->hasRole('admin')) {
            return $this->respondForbidden();
        }

        $request->validate([
            'status' => 'required|in:1,0',
            'user_id' => 'required|numeric'
        ]);

       $user = User::findOrFail($request->user_id);
       $user->status = $request->status;
       $user->save();

       return $this->respondWithSuccess();
    }

    public function uploadAvatar(Request $request, $userId)
    {
        $request->validate([
            'avatar' => 'required|file|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $path = $request->file('avatar')->store('public/avatars');
        $avatar = explode('/',$path)[2];
        $avatar_url = asset("storage/avatars/{$avatar}");
        return compact('avatar','avatar_url');
    }
}
