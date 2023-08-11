<?php


namespace App\Traits;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait CreateUserTrait
{

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $data['password'] =  $data['password'] ?? Str::random(8);
        $user =  User::create([
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'other_name' => $data['other_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'password' => $data['password'],
            'status' => User::STATUS_ACTIVE,
            'state' => $data['state'] ?? null,
        ]);
        $user->orgianl_password = $data['password'];
        return $user;
    }

}
