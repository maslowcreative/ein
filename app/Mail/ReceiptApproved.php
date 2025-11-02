<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptApproved extends Mailable
{
    use Queueable, SerializesModels;
    
    public $provider;
    public $claimReference;
    public $subject;
    public $heading;
    public $ccEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($provider, $claimReference)
    {
        $this->provider = $provider;
        $this->claimReference = $claimReference;
        $providerName = $this->provider->user->other_name;

        $this->subject = "EIN admin has approved a receipt from {$providerName} - Claim Ref: {$claimReference}";
        $this->heading = "EIN admin has approved a receipt from {$providerName} for you to accept or reject.";
        $this->ccEmail = env('CLAIM_BCC_EMAIL', 'serviceprovider@ein.net.au');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.receipts.approved')->cc($this->ccEmail);
    }
}
