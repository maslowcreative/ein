<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class CreateRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'id' => Role::ROLE_ADMIN,
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'id' => Role::ROLE_PROVIDER,
                'name' => 'provider',
                'guard_name' => 'web'
            ],
            [
                'id' => Role::ROLE_REPRESENTATIVE,
                'name' => 'representative',
                'guard_name' => 'web'
            ],
            [
                'id' => Role::ROLE_PARTICIPANT,
                'name' => 'participant',
                'guard_name' => 'web'
            ]

        ];
        Role::upsert($data,['id'],['name','guard_name']);
    }
}
