<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUsers extends Seeder
{
    const ADMIN_ID = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                "id" => self::ADMIN_ID,
                "name" => "Admin",
                "email" => "admin@ein.net.au",
                "password" => Hash::make("demo123$"),
                "status" => User::STATUS_ACTIVE
            ]
        ];
        User::upsert($admin,['id'],['name','email','password']);
        User::find(self::ADMIN_ID)->assignRole(Role::ROLE_ADMIN);
        Admin::upsert([['user_id'=> self::ADMIN_ID]],['user_id'],['user_id']);
    }
}
