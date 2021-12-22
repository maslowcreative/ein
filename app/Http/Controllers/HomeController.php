<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;
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
        return view('my-account');
    }

    public function claimInvoiceDownload(Claim $claim){
        return Storage::download($claim->invoice_path);
    }

    public function planFileDownload($fileName){
        return Storage::download('plans/'.$fileName);
    }
}
