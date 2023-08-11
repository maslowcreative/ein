<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Plan;
use App\Models\User;
use Box\Spout\Common\Exception\IOException;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class ParticipantOldDataSeeder extends Seeder
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
            $collection = (new FastExcel())->import("{$basePath}/ParticipantMaster.xlsx");

        }catch (IOException $e){
            $collection = [];
        }

        $password = 'demo123$';
        foreach ($collection as $item){
            if($item['Participant_Number'] == '' || $item['Participant_Number'] == null)
            {
                continue;
            }
            $user = User::updateOrCreate(
                [
                    'temp_ndis_number' => $item['Participant_Number']
                ],
                [
                    'name' => $item['Participant_Name'],
                    'email' => Str::random(8) ."@participant.ein.net.au",
                    'password' => $password,
                    'status' => 1
                ]
            );
            Participant::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'old_id' => $item['ID'],
                    'dob' => $item['Participant_DOB']  != ''?  $item['Participant_DOB']->format('Y-m-d') : null,
                    'ndis_number' => $item['Participant_Number']
                ]
            );
            $user->assignRole('participant');


            Plan::updateOrCreate(
                [
                    'participant_id' => $user->id
                ],
                [
                    'start_date' => $item['Plan_Start']  != '' ?  $item['Plan_Start']->format('Y-m-d') : null,
                    'end_date' => $item['Plan_End']  != '' ?  $item['Plan_End']->format('Y-m-d') : null,
                    'budget' => null,
                    'status' => 1
                ]
            );
        }
    }
}
