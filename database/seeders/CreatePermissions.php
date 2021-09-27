<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreatePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'create-provider',
                'guard_name' => 'web'
            ],
            [
                'id' => 2,
                'name' => 'update-provider',
                'guard_name' => 'web'
            ],
            [
                'id' => 3,
                'name' => 'create-participant',
                'guard_name' => 'web'
            ],
            [
                'id' => 4,
                'name' => 'update-participant',
                'guard_name' => 'web'
            ],
            [
                'id' => 5,
                'name' => 'create-representative',
                'guard_name' => 'web'
            ],
            [
                'id' => 6,
                'name' => 'update-representative',
                'guard_name' => 'web'
            ],
            [
                'id' => 7,
                'name' => 'approve-claim',
                'guard_name' => 'web'
            ],
            [
                'id' => 8,
                'name' => 'export-document',
                'guard_name' => 'web'
            ],
            [
                'id' => 9,
                'name' => 'import-document',
                'guard_name' => 'web'
            ],
        ];
        Permission::upsert($data,['id'],['name','guard_name']);
    }
}
