<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;
    private $provider;
    public $subject;
    public $heading;
    public $ccEmail;
    public $currentRole;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($provider, $currentRole = 'provider', $repName = null)
    {
        $this->provider = $provider;
        $providerName = $this->provider->user->other_name;
        
        $this->currentRole = $currentRole;
        
        if($this->currentRole == 'admin'){
            $this->subject = "EIN admin has uploaded an invoice from {$providerName}";
            $this->heading = "EIN admin has uploaded an invoice from {$providerName} for you to accept or reject.";
        }elseif($this->currentRole == 'representative'){
            $this->subject = "{$repName} has uploaded a receipt for approval.";
            $this->heading = "{$repName} has uploaded a receipt for approval.";
        }else{
            $this->subject = "{$providerName} has uploaded an invoice";
            $this->heading = "{$providerName} has uploaded an invoice for you to accept or reject.";
        }
        
        if($this->currentRole != 'representative'){
            $this->ccEmail = env('CLAIM_BCC_EMAIL','serviceprovider@ein.net.au');
        }
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        

        return $this->markdown('emails.invoices.created',[
            'providerName' => $this->provider->user->other_name,
            'heading' => $this->heading,
        ])->cc($this->ccEmail);
    }
}
