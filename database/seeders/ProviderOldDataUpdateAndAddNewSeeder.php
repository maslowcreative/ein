<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Representative;
use App\Models\User;
use Box\Spout\Common\Exception\IOException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ProviderOldDataUpdateAndAddNewSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $basePath = Storage::path('data');
            $collection = (new FastExcel())->sheet(1)->import("{$basePath}/MasterTables.xlsx");
        }catch (IOException $e){
            $collection = [];
        }

        $password = 'demo123$';

        foreach ($collection as $item){

            if($item['Provider_Remittance_Email'] == '' || $item['Provider_Remittance_Email'] == null)
            {
                continue;
            }

            $name = preg_replace("/[[:blank:]]+/"," ",$item['Provider_Name']);
            $names = explode(' ',trim($name));
            if ( count($names) == 1 ){
                $first_name = $names[0];
                $last_name = '';
            }else {
                $first_name = $names[0];
                unset($names[0]);
                $last_name = implode(' ',$names);
            }

            $user = User::updateOrCreate(
                [
                    'email' => $item['Provider_Remittance_Email']
                ],
                [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'other_name' => $item['Provider_Name'],
                    'password' => $password,
                    'email_verified_at' => 1,
                    'status' => 1,
                    'source' => 'porvider_update',
                    //'created_at' => $now,
                    //'updated_at' => $now,
                ]
            );

            Provider::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'abn' => str_replace(' ','',$item['ABN']),
                ]
            );
            $user->removeRole('representative');
            Representative::where('user_id',$user->id)->delete();
            $user->assignRole('provider');

            if(str_replace(' ','',$item['ABN']) == 'REMIB'){
                $user->email = 'remib.'.$user->email;
                $user->save();
            }

        }


        $providerIds = Provider::pluck('user_id');

        $providerIdsToDell = User::whereNull('source')->pluck('id');

        User::whereNull('source')
                    ->whereIn('id',$providerIds)
                    ->delete();

        Provider::whereIn('user_id',$providerIdsToDell)->delete();
    }
}
