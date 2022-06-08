<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanBudget;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

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
            ->orderBy('status', 'desc')
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
            'end_date' => 'required'
        ]);

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
}
