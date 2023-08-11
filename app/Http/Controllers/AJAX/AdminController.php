<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasRole('admin')) {
            return $this->respondForbidden();
        }

        $admins = User::getUsers()
                      ->with('permissions')
                      ->whereInRoles(['sub-admin'])
                      ->paginate(5);
        return  $admins;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function updatePermissions(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$request->user_id
        ]);

        if(!Auth::user()->hasRole('admin')) {
            return $this->respondForbidden();
        }

        $user = User::findorFail($request->user_id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        $user->save();

        $permissions = collect($request->permissions)->filter(function ($value, $key) {
            return $value == true;
        })->keys();

        $user->syncPermissions($permissions);

        return $this->respondCreated();
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
