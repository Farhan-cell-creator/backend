<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;

class VisitorController extends Controller
{
    //
     public function details(Request $request)
    {
       
        $ip ='223.123.6.236';

       
        $location = Location::get($ip);

      
        $agent = new Agent();
         if (!$ip) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to detect visitor Ip'
                ], 400);
            }

        return response()->json([
            'message' => 'Read Data Successfully',
            'success' => true,

            'ip' => $ip,

            'location' => $location,

            'browser' => [
                'name' => $agent->browser(),
                'version' => $agent->version($agent->browser()),
            ],

            'device' => [
                'type' => $agent->device(),
                'mobile' => $agent->isMobile(),
                'tablet' => $agent->isTablet(),
                'desktop' => $agent->isDesktop(),
            ],

            'platform' => [
                'name' => $agent->platform(),
                'version' => $agent->version($agent->platform()),
            ],

           
        ], 200);
    }
}
