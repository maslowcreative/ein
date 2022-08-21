<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BankInformationUpdated extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The subject of the message.
     *
     * @var string
     */
    public $subject;

    private $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $role = $this->user->roles()->first();
        $data = [
            'role' => ucfirst($role->name),
            'name' => $this->user->name,
            'account_number' => $this->user->account_number,
            'account_name' => $this->user->account_name,
            'bsb' => $this->user->bsb,
            'is_provider' => 0,
            'url' => route('home')
        ];
        $this->subject = $data['name']. " (". $data['role'] . ") updated its banking information";
        if($role->name == 'provider'){
            $data['abn'] = $this->user->provider->abn;
            $data['is_provider'] = 1;
        }

        return $this->markdown('emails.users.bank-info-updated',$data);
    }
}
