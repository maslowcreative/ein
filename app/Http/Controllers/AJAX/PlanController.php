<?php

namespace App\Http\Controllers\AJAX;

use App\Http\Controllers\Controller;
use App\Models\Plan;
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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'file_name' => 'string',
            'status' => 'required|boolean',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $plan->fill($request->all())->save();

        return $this->respondWithSuccess();
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
