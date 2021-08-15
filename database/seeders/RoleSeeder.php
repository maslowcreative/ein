<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
              'id' => 1,
              'name' => 'admin',
              'guard_name' => 'api'
            ],
            [
                'id' => 2,
                'name' => 'provider',
                'guard_name' => 'api'
            ],
            [
                'id' => 3,
                'name' => 'representative',
                'guard_name' => 'api'
            ],
            [
                'id' => 4,
                'name' => 'participant',
                'guard_name' => 'api'
            ]
        ];

        Role::upsert($roles, ['id'], ['name','guard_name']);


    }
}
