<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CleanClaimPostRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->hasFile('file')){

            $chunks = array_chunk($request->service,8);
            $service = [];
            foreach ($chunks as $chunk) {
                $dot = Arr::dot($chunk);
                array_push($service,[
                    'item_number' => $dot['0.item_number'],
                    'claim_type' => $dot['1.claim_type'],
                    'hours' => $dot['2.hours'],
                    'unit_price' => $dot['3.unit_price'],
                    'gst_code' => $dot['4.gst_code'],
                    'cancellation_reason' => $dot['5.cancellation_reason'],
                    //'item_name' => $dot['6.item_name'],
                    //'max_unit_price' => $dot['7.max_unit_price'],
                ]);
            }
            $input = $request->all();
            $input['service'] = $service;
            $request->replace($input);
        }
        return $next($request);
    }
}
