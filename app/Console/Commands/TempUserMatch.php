<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TempUserMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:user-match';

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
        $providers = DB::table('temp_user')->where('type','provider')->get();

        foreach ($providers as $provider){
            $p = \App\Models\User::where('other_name',$provider->sheet_name)->whereHas('provider')->first();
            if($p){
                DB::table('temp_user')->where('id',$provider->id)->update([
                    'user_id' => $p->id,
                    'user_email' => $p->email
                ]);
            }

        }

        $participants = DB::table('temp_user')->where('type','participant')->get();

        foreach ($participants as $participant){
            $names = explode(' ',$participant->sheet_name);
            $p = \App\Models\User::where('first_name',$names[0])
                ->where('last_name',$names[1])
                ->whereHas('participant')->first();
            if($p){
                DB::table('temp_user')->where('id',$participant->id)->update([
                    'user_id' => $p->id,
                ]);
            }

        }
    }
}
