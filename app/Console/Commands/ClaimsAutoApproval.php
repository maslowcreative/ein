<?php

namespace App\Console\Commands;

use App\Mail\ClaimsAutoApprved;
use App\Models\Claim;
use App\Models\ClaimLineItem;
use App\Traits\ClaimsValidationTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClaimsAutoApproval extends Command
{
    use ClaimsValidationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claims:auto-approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will auto approve claims on behalf of representative.';

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

        $items = DB::table('claim_line_items as cli')
                              ->where('status',Claim::STATUS_APPROVAL_PENDING)
                              ->whereRaw("NOW() >= DATE_ADD(cli.created_at , INTERVAL (r.auto_approval_days * 24)  HOUR)")
                              ->select('p.representative_id','r.auto_approval_days')
                              ->join('participants as p','p.user_id','=','cli.participant_id')
                              ->join('representatives as r','r.user_id','=','p.representative_id')
                              ->select('cli.id as claim_line_item_id','r.auto_approval_days','cli.participant_id','p.representative_id')
                              ->get()
                              ->toArray();
        $data = [];

        foreach ($items as $index => $item ){
            $claim = ClaimLineItem::find($item->claim_line_item_id);
            $claimData = $this->claimValidate($claim);

            if(!$claimData['status']){
                $claim->auto_approval_process_counter =  $claim->auto_approval_process_counter + 1;
                $claim->auto_approval_status = $claimData['message'];
                $claim->last_auto_approval_process_date = Carbon::now();
                $claim->save();
                $this->info("Claim No {$item->claim_line_item_id}: {$claimData['message']}");
                array_push($data,[
                    'claim_id'=> $claim->claim_id,
                    'provider_id' =>  $claim->provider_id,
                    'participant_id' => $claim->participant_id,
                    'claim_reference' => $claim->claim_reference,
                    'reason' => $claimData['message']
                ]);
                continue;
            }

            $this->info("{$item->claim_line_item_id} : Processable");

            DB::transaction(function () use ($claim,$claimData,&$data) {
                $catBudget = $claimData['catBudget'];
                $catBudget->balance = $catBudget->balance - $claim->amount_claimed;
                $catBudget->pending = $catBudget->pending + $claim->amount_claimed;
                $catBudget->save();
                $claim->plan_id = $catBudget->plan_id;
                $claim->category_id = $catBudget->category_id;
                $claim->status = Claim::STATUS_APPROVED_BY_REPRESENTATIVE;
                $claim->auto_approval_process_counter =  $claim->auto_approval_process_counter + 1;
                $claim->auto_approval_status = 'success';
                $claim->last_auto_approval_process_date = Carbon::now();
                $claim->save();
                $this->info("Claim No {$claim->id}: Success");

                array_push($data,[
                    'claim_id'=> $claim->claim_id,
                    'provider_id' =>  $claim->provider_id,
                    'participant_id' => $claim->participant_id,
                    'claim_reference' => $claim->claim_reference,
                    'reason' => 'Success'
                ]);
            });
        }


        $toEmail = config('app.ein_notify_email');

        Mail::to($toEmail)
            ->bcc('ameerharram@gmail.com')
            ->send(new ClaimsAutoApprved($data));



        $this->info("Claim Approval executed.");
        return 1;
    }
}
