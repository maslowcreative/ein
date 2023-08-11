<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimsAutoApprved extends Mailable
{
    use Queueable, SerializesModels;

    private $claimData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->claimData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject = "Claims Auto Approval";
        return $this->markdown('emails.invoices.claims-auto-approved',['data' =>  $this->claimData]);
    }
}
