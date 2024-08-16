<?php

namespace App\Http\Controllers;

use App\Jobs\Process80BudgetExceeded;
use App\Mail\ProviderBudgetExceeded;
use App\Models\Claim;
use App\Models\ProviderBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('bank.info.check')->only('index','myAccount');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (auth()->user()->roles[0]->name){
            case 'admin':
                $view =  view('home-admin');
            break;
            case 'sub-admin':
                $view =  view('home-admin');
                break;
            case 'provider':
                $view =  view('home-provider');
            break;
            case 'participant':
                $view =  view('home-participant');
            break;
            case 'representative':
                $view =  view('home-representative');
            break;
            default:

        }
        return $view;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function myAccount()
    {
        $user = auth()->user();
        $role = $user->roles[0]->name;
        return view('my-account',['user' => $user, 'role' => $role]);
    }

    public function claimInvoiceDownload(Claim $claim){
        return Storage::download($claim->invoice_path);
    }

    public function planFileDownload($fileName){
        return Storage::download('plans/'.$fileName);
    }

    public function analytics()
    {
        if( auth()->user()->hasRole('representative') || auth()->user()->hasRole('admin') ){
            return view('analytics');
        }if( auth()->user()->hasRole('sub-admin') && auth()->user()->hasPermissionTo('add_edit_plans')){           
            return view('analytics');
        }
        else{
        
            return redirect()->route('home');
        }

    }

    public function providerBudgetAllocations()
    {
        if( auth()->user()->hasRole('provider')){
            return view('provider-plan-budget');
        }else{
            return redirect()->route('home');
        }
    }

    public function jobTest()
    {
       $providerBudgets =  ProviderBudget::with('plan','planBudget')
                                        ->orderBy('id','desc')
                                        ->get()
                                        ->take(15);
       $array = [];
       foreach ($providerBudgets as $providerBudget){
           $percentage = ($providerBudget->spent / $providerBudget->amount) * 100;
           if($percentage>= 80)
           {
                $data = [
                    'participant_id' => $providerBudget->plan->participant_id,
                    'percentage_exceeded' => $percentage,
                    'providerCatBudget' =>$providerBudget
                ];
               Mail::to(env('EIN_ADMIN_EMAIL'))
                   ->send(new ProviderBudgetExceeded($data));
                array_push($array,$data);

           }
       }

        //Process80BudgetExceeded::dispatch($array);
       return 'Mail sent.';
    }
}
