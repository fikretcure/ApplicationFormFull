<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class LocationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         $ip = "95.70.185.251"; // türkiyeye ait ip
        // $ip = "69.197.185.43"; // ingiltere ait ip
        //$ip = "5.45.207.149"; // rusya ait ip
        switch (Location::get($ip)->countryName) {
            case 'Turkey':
            case 'United States':
            case 'Russia':
                return response()->json("Mevcut " . "(" . Location::get($ip)->countryName . ")" . " lokasyonunuzdan başvuru yapamazsınız !", 421);
                break;
            default:
                # code...
                break;
        }
        return $next($request);
    }
}
