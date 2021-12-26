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
                'name' => 'edit_provider_profiles',
                'guard_name' => 'web'
            ],
            [
                'id' => 2,
                'name' => 'edit_participants_profiles',
                'guard_name' => 'web'
            ],
            [
                'id' => 3,
                'name' => 'edit_representatives_profiles',
                'guard_name' => 'web'
            ],
            [
                'id' => 4,
                'name' => 'approving_claims',
                'guard_name' => 'web'
            ],
            [
                'id' => 5,
                'name' => 'export_import_documents',
                'guard_name' => 'web'
            ]
        ];
        Permission::upsert($data,['id'],['name','guard_name']);
    }
}
