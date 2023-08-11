<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\User;
use Box\Spout\Common\Exception\IOException;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ProviderOldDataSeeder extends Seeder
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
            $collection = (new FastExcel())->import("{$basePath}/ProviderMaster.xlsx");

        }catch (IOException $e){
            $collection = [];
        }
        $password = 'demo123$';

        foreach ($collection as $item){
            if($item['Provider_RemittanceEmail'] == '' || $item['Provider_RemittanceEmail'] == null)
            {
                continue;
            }

            $user = User::updateOrCreate(
                        [
                            'email' => $item['Provider_RemittanceEmail']
                        ],
                        [
                            'name' => $item['Provider_Name'],
                            'password' => $password,
                            'email_verified_at' => 1,
                            'status' => 1,
                            //'created_at' => $now,
                            //'updated_at' => $now,
                        ]
                    );

            Provider::updateOrCreate(
              [
                  'user_id' => $user->id
              ],
              [
                  'old_id' => $item['ID'],
                  'abn' => $item['Provider_BNumber'],
                  'bsb_number' => $item['Provider_BSBsans'],
                  'business_name' => $item['Provider_BName'],
              ]
            );

          $user->assignRole('provider');
        }
    }
}
