<?php

namespace App\Jobs;

use App\Mail\ProviderBudgetExceeded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Process80BudgetExceeded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $array;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->array as $data){
            Mail::to(env('EIN_ADMIN_EMAIL'))
                   ->send(new  ProviderBudgetExceeded($data));
        }
    }
}
