<?php

namespace App\Console\Commands;

use App\Models\Participant;
use http\Client\Curl\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class TempUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $basePath = Storage::path('data');

            DB::table('temp_user')->truncate();
            //$collection = (new FastExcel())->import("{$basePath}/Genius to ClaimMaster 23 to 30SEP21.csv");
            $collection = (new FastExcel())->import("{$basePath}/New All Claims Sheet.xlsx");

            $providerNames =  $collection->pluck('ProviderMaster_ID')
                                        ->unique();
            foreach ($providerNames as $name){
                DB::table('temp_user')->insert([
                    'sheet_name' => $name,
                    'type' => 'provider'
                ]);
            }

            $participantNames =  $collection->pluck('ParticipantMaster_ID')
                                            ->unique();

            foreach ($participantNames as $name){
                DB::table('temp_user')->insert([
                    'sheet_name' => $name,
                    'type' => 'participant'
                ]);
            }



        }catch (IOException $e){
            $collection = [];
        }
        return 0;
    }
}
