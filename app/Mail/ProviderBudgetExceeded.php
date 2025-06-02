<?php

namespace App\Mail;

use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class ProviderBudgetExceeded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->data['participant_id']);
        $category = ServiceCategory::where('id',$this->data['providerCatBudget']->category_id)->first();
        $this->subject = $user->first_name .' '. $user->last_name. ' ('.$category->short_name .') "Budget limit exceeded."';
        $url = route('analytics',['plan_id' => $this->data['providerCatBudget']->plan_id,'participant_id' =>  $this->data['participant_id']]);

        $data = [
            'name' => $user->first_name .' '. $user->last_name,
            'cateogry_name' => $category->short_name,
            'percentage_exceeded' => $this->data['percentage_exceeded'],
            'url' => $url,
        ];

        return $this->markdown('emails.provider-budget-exceeded',$data)
                    ->from(env('EIN_FROM_EMAIL'), env('EIN_FROM_NAME'))
                    ->bcc('ameerharram@gmail.com');
    }
}
