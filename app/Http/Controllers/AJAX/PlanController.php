<?php

namespace App\Http\Controllers\AJAX;

use App\Console\Commands\BudgetBalancing;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderBudgetAllocationRequest;
use App\Models\Plan;
use App\Models\PlanBudget;
use App\Models\ProviderBudget;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    use ApiResponseHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $participantId = $request->user_id;

        $plans = Plan::where('participant_id',$participantId)
            ->with('budgets')
            ->orderBy('start_date', 'desc')
            ->get();

        return $plans;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'nullable|string',
            'status' => 'required|boolean',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'participant_id' => 'required|numeric',
            'budget' => 'required|numeric|min:1',
        ]);

        if($request->status == 1){
            $plans = Plan::where('participant_id',$request->participant_id)
                ->where('status',1)
                ->get();
            if(count($plans) > 0){
                return $this->respondError(__('A plan with active state already exists.'));
            }

        }
        DB::beginTransaction();
        $plan = new Plan();
        $plan->file_name = $request->file_name;
        $plan->participant_id = $request->participant_id;
        $plan->status = $request->status;
        $plan->start_date = $request->start_date;
        $plan->end_date = $request->end_date;
        $plan->budget = $request->budget;
        $plan->save();

        $bugdetCategories = [];
        foreach($request->budgets as $key => $val) {
            $cat = explode('_',$key);
            if($cat[0] == 'cat'){
                array_push(
                    $bugdetCategories,
                    [
                        'category_id' => $cat[1],
                        'amount' => $val,
                        'balance' => $val,
                        'pending' => 0,
                        'spent' => 0,
                    ]
                );
            }
        }
        $plan->budgets()->createMany($bugdetCategories);
        DB::commit();
        return $plan;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            //'plan_name' => 'required',
            'file_name' => 'nullable|string',
            'budget' => 'required|numeric',
            'status' => 'required|boolean',
            'start_date' => 'required',
            'end_date' => 'required',
            'budgets' => 'required|array',
            'budgets.cat_1' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',1)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_2' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',2)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_3' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',3)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_4' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',4)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_5' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',5)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_6' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',6)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_7' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',7)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_8' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',8)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_9' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',9)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_10' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',10)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_11' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',11)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_12' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',12)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_13' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',13)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_14' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',14)->where('plan_id',$plan->id)->first();
                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
            'budgets.cat_15' => ['numeric',function ($attribute, $value, $fail) use ($plan){
                $budget = PlanBudget::where('category_id',15)->where('plan_id',$plan->id)->first();

                if(false && $budget && $value < $budget->amount)
                {
                    $fail('New value cannot be less than the old value.');
                }
            }],
        ]);

        if($request->status == 1){
            $plans = Plan::where('participant_id',$plan->participant_id)
                        ->where('status',1)
                        ->where('id','<>',$plan->id)
                        ->get();
            if(count($plans) > 0){
                return $this->respondError(__('A plan with active state already exists.'));
            }

        }

        $plan->fill($request->all())->save();

        foreach($request->budgets as $key => $val) {
            $cat = explode('_',$key);
            if($cat[0] == 'cat'){
                $buget = PlanBudget::where('category_id',$cat[1])
                           ->where('plan_id',$plan->id)
                           ->first();
                if(!$buget){
                    $buget = new PlanBudget();
                    $buget->category_id = $cat[1];
                    $buget->plan_id = $plan->id;
                }
                $buget->amount = $val;
                $buget->balance =  $buget->amount - ( $buget->spent + $buget->pending );
                $buget->save();
            }
        }

        return $plan->load('budgets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPlanFile(Request $request)
    {
        $request->validate(['file' => 'required|mimes:pdf' ]);
        $path = $request->file('file')->store('plans');
        $file_name = explode('/',$path)[1];
        return $this->respondWithSuccess(compact('file_name'));
    }

    public function getSpendingData(Request $request)
    {
        $user = Auth::user();

         if($user->hasRole('representative')) {
            $repId = $user->id;
            $request->validate([
                'participant_id' => [
                    'required',
                    Rule::exists('participants','user_id')->where(function ($query) use ($repId) {
                        return $query->where('representative_id', $repId);
                    }),
                ]
            ]);
        }
        else
        {
            if(!$user->hasRole('admin'))
            {
                return $this->respondForbidden();
            }

        }

        $plan = Plan::where('participant_id',$request->participant_id)
                    ->where('id',$request->plan_id)
                    ->first();

        if(!$plan)
        {
            return $this->respondError('No active plan exists for this participant');
        }

        $planBugets = PlanBudget::where('plan_id',$plan->id)
                                ->where('amount' ,'>',0)
                                ->with('category')
                                ->orderBy('category_id')
                                ->get();

        if(!$planBugets->count())
        {
            return $this->respondError('No plan category exists with plan budget');
        }
        $planBugetsFiltered  = $planBugets->where('category.short_name' ,'<>','Plan Management');
        $spendingData = [
            'graph' => [
                    'labels' => $planBugetsFiltered->pluck('category.short_name')->toArray(),
                    'amount' => $planBugetsFiltered->pluck('amount')->toArray(),
                    'balance' => $planBugetsFiltered->pluck('balance')->toArray(),
                    'pending' => $planBugetsFiltered->pluck('pending')->toArray(),
                    'spent' => $planBugetsFiltered->pluck('spent')->toArray(),
                ],
            'table' => $planBugets->toArray(),
            'plan' => [
                'start_date' => $plan->start_date_formatted,
                'end_date' => $plan->end_date_formatted,
                'status' => $plan->status,
            ]
        ];

        return $this->respondWithSuccess($spendingData);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateProviderBudgetAllocation(ProviderBudgetAllocationRequest $request)
    {
        $planBudget = PlanBudget::where('plan_id',$request->plan_id)->where('category_id',$request->category_id)->firstOrFail();

        $providersCollection = $request->providers_collection;

        $totalAmount = collect($providersCollection)->sum(function ($item) {
            return $item['budget'];
        });

        if($totalAmount > $planBudget->amount){
            return  $this->respondError('Total amount exceeded.');
        }

        $budgets = collect([]);


        foreach ($providersCollection as $provider){

            $providerBudget = ProviderBudget::where('provider_id',$provider['providerItemsResultSelected']['id'])
                                             ->where('category_id',$request->category_id)
                                             ->where('plan_id',$request->plan_id)
                                             ->where('plan_budget_id',$planBudget->id)
                                             ->first();
            if(!$providerBudget){
                $providerBudget = new ProviderBudget();
                $providerBudget->provider_id = $provider['providerItemsResultSelected']['id'];
                $providerBudget->category_id = $request->category_id;
                $providerBudget->plan_id = $request->plan_id;
                $providerBudget->plan_budget_id = $planBudget->id;
                $providerBudget->amount = $provider['budget'];
                $providerBudget->balance = $provider['budget'];
                $providerBudget->pending = 0;
                $providerBudget->spent = 0;
            }else
            {
                if($provider['budget'] < $providerBudget->amount )
                {
                    return  $this->respondError('New value cannot be less than the old value.');
                }else
                {
                    $providerBudget->balance = $providerBudget->balance + ($provider['budget'] - $providerBudget->amount);
                    $providerBudget->amount = $provider['budget'];
                }
            }
            $budgets->push($providerBudget);

        }

        foreach ($budgets as $budget)
        {
            $budget->save();
        }
        $ids = $budgets->pluck('id');

        $objs = ProviderBudget::where('category_id',$request->category_id)
                              ->where('plan_id',$request->plan_id)
                              ->where('plan_budget_id',$planBudget->id)
                              ->whereNotIn('id', $ids)
                              ->get();

        foreach ($objs as $obj)
        {
            $obj->delete();
        }

        return $this->respondWithSuccess();
    }

    public function getProviderBudgetAllocation(Request $request)
    {
        $planBudget = PlanBudget::where('plan_id',$request->plan_id)->where('category_id',$request->category_id)->firstOrFail();

        $providerBudget = ProviderBudget::where('category_id',$request->category_id)
                                        ->where('plan_id',$request->plan_id)
                                        ->where('plan_budget_id',$planBudget->id)
                                        ->with(['user' => function ($query) {
                                            $query->withTrashed();
                                            $query->with('roles');
                                        }])
                                        ->get();
        return  $providerBudget;

    }

}
