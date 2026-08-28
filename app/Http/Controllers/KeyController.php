<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeyController extends Controller
{
    //
    public function authenticate()
    {
        return response()->json([
          'message'=>'Authentic User',
           'sucess'=>true
        ]);
    }
}
