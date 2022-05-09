<?php

namespace Database\Seeders;

use App\Models\Provider;
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
            $collection = (new FastExcel())->import("{$basePath}/ProviderMasterNew.xlsx");
        }catch (IOException $e){
            $collection = [];
        }

        $password = 'demo123$';

        foreach ($collection as $item){
            if($item['Provider_Remittance_Email'] == '' || $item['Provider_Remittance_Email'] == null)
            {
                continue;
            }

            $user = User::updateOrCreate(
                [
                    'email' => $item['Provider_Remittance_Email']
                ],
                [
                    'name' => $item['Provider_Name'],
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

            $user->assignRole('provider');
        }


        $providerIds = Provider::pluck('user_id');

        $providerIdsToDell = User::whereNull('source')->pluck('id');

        User::whereNull('source')
                    ->whereIn('id',$providerIds)
                    ->delete();

        Provider::whereIn('user_id',$providerIdsToDell)->delete();
    }
}
