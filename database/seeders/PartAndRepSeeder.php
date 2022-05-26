<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Plan;
use App\Models\Representative;
use App\Models\Role;
use App\Models\User;
use Box\Spout\Common\Exception\IOException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class PartAndRepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $states =  collect([
            "ACT" => 'Australian Capital Territory',
            "NSW" => 'New South Wales',
            "NT" => 'Northern Territory',
            "QLD" => 'Queensland',
            "SA" => 'South Australia',
            "TAS" => 'Tasmania',
            "VIC" => 'Victoria',
            "WA" => 'Western Australia'
        ]);

        try {
            $basePath = Storage::path('data');
            $collection = (new FastExcel())->sheet(2)->import("{$basePath}/MasterTables.xlsx");

            $password = 'demo123$';

            foreach ($collection as $item){

                $state = $states->search($item['State']);

                $dob = explode( '/',$item['DOB']);

                $dob = $dob[2] .'-'. $dob[1]. '-'.$dob[0];

                if($item['Signup Date'] instanceof \DateTime){
                    $signup = $item['Signup Date'];
                }
                else
                {
                    $signup = explode( '/',$item['Signup Date']);
                    $signup = $signup[2] .'-'. $signup[1]. '-'.$signup[0].' 00:00:00';
                }
                $repNames = explode(' ',$item['Representative']);
                $repFirstName = $repNames[0];
                $repOtherName = $repFirstName;
                if( count($repNames) > 1 ){
                    $repLastName = $repNames[1];
                    $repOtherName = $repOtherName. ' '. $repLastName;
                }

                $participant = Participant::where('ndis_number',$item['Participant #'])
                                          ->first();

                $representative = User::where('email',$item['Representative Email'])
                                      ->whereHas('representative')
                                      ->first();


                if($participant) {
                    $participant->dob = $dob;
                    $participant->sr_no = $item['ID'];
                    $participant->created_at = $signup;
                    $participant->save();

                    $user = User::find($participant->user_id);
                    if($user){
                        $user->first_name = $item['Participant First Name'];
                        $user->last_name = $item['Participant Last Name'];
                        $user->other_name = $item['Participant First Name'].' '.$item['Participant Last Name'];
                        $user->state = $state;
                        $user->save();
                    }
                }
                else
                {
                    $user = User::create([
                        'first_name' => $item['Participant First Name'],
                        'last_name' => $item['Participant Last Name'],
                        'other_name' => $item['Participant First Name'].' '.$item['Participant Last Name'],
                        'email' => Str::random(8) ."@participant.ein.net.au",
                        'password' => Hash::make($password),
                        'state' => $state,
                        'created_at' => $signup
                    ]);

                    $participant = $user->participant()->create([
                                'sr_no' => $item['ID'],
                                'dob' => $dob,
                                'ndis_number' => $item['Participant #'],
                                'created_at' => $signup
                            ]);
                }

                $repUser = User::where('email',trim($item['Representative Email']))->withTrashed()->first();
                if($repUser) {
                    $repUser->first_name = $repFirstName;
                    $repUser->last_name = $repLastName;
                    $repUser->other_name = $repOtherName;
                    $repUser->created_at = $signup;
                    $repUser->save();

                    $rep = Representative::where('user_id',$repUser->id)->first();
                    if($rep)
                    {
                        $rep->flag_email = $item['Representative Email'];
                        $rep->save();
                    }else
                    {
                        $repUser->representative()->create([
                            'flag_email' => $item['Representative Email'],
                            'created_at' => $signup
                        ]);
                    }

                }
                else
                {
                    $repUser = User::create([
                        'first_name' => $repFirstName,
                        'last_name' => $repLastName,
                        'other_name' => $repOtherName,
                        'email' => $item['Representative Email'],
                        'password' => Hash::make($password),
                        'created_at' => $signup
                    ]);

                    $repUser->representative()->create([
                        'flag_email' => $item['Representative Email'],
                        'created_at' => $signup
                    ]);
                }

                $participant->representative_id = $repUser->id;
                $participant->save();

                $user->assignRole(Role::ROLE_PARTICIPANT);
                $repUser->assignRole(Role::ROLE_REPRESENTATIVE);

            }

        }catch (IOException $e){
            $collection = [];
        }

    }
}
