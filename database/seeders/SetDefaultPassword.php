<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SetDefaultPassword extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::withTrashed()->get();

        foreach ($users as $user)
        {

            $user->password = 'demo123$';
            $user->save();

        }
    }
}
