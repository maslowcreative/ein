<?php

namespace App\Jobs;

use App\Mail\ReceiptApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReceiptApprovedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $provider;
    protected $claimReference;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $provider, $claimReference)
    {
        $this->email = $email;
        $this->provider = $provider;
        $this->claimReference = $claimReference;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new ReceiptApproved($this->provider, $this->claimReference));
    }
}
