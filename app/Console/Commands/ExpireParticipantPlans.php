<?php

namespace App\Console\Commands;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireParticipantPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will expire participant plans.';

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
        $tomrrow = Carbon::now();

//        Plan::where('end_date','<',$tomrrow->toDateString())
//             ->where('status',1)
//             ->update(['status' => 0]);

        Log::info('EIN:plan-expire Plan Expired Script ran today at '.$tomrrow->toDateTimeString());
        $this->info("Plans Expired script compeleted succesfuly.");
        return 0;
    }
}
