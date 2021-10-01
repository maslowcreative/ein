<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Models\Participant;
use App\Models\Role;
use App\Models\User;
use App\Traits\CreateUserTrait;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                     ->whereNotInRoles(['admin'])
                     ->paginate(5);
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
        }
        //Participant Role:
        if(Role::ROLE_PARTICIPANT == $role->id) {
          $participant = $user->participant()->create($request->participant);
          if($request->participant['plan'] ?? false)
            $plan = $participant->plans()->create($request->participant['plan']);
        }
        //Representative Role:
        if(Role::ROLE_REPRESENTATIVE == $role->id) {
          $representative = $user->representative()->create();

          if($request->representative['participants'] ?? false){
              foreach ($request->representative['participants'] as $participant)
              {
                Participant::find($participant['participants_id'])
                           ->fill(['representative_id' => $representative->id,'relationship'=>$participant['relationship']])
                           ->save();
              }
          }
        }

        //Representative Admin:
        if(Role::ROLE_ADMIN == $role->id) {
            $admin = $user->admin()->create();
        }

        //Send Password Email:
//        if(Role::ROLE_PARTICIPANT != $role->id)
//            event(new Registered($user));

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
        dd('check');
        return $this->respondCreated();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
