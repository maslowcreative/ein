<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserFirstAndLastNameSeeder extends Seeder
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

          $name = preg_replace("/[[:blank:]]+/"," ",$user->name);
          $names = explode(' ',trim($name));
          if ( count($names) == 1 ){
              $user->first_name = $names[0];
              $user->last_name = '';
          }else {


              $user->first_name = $names[0];
              unset($names[0]);
              $user->last_name = implode(' ',$names);
          }
          $user->save();

        }
    }
}
