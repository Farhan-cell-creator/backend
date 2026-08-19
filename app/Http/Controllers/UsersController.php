<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'max:255'],
    ]);

    $result = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    return response()->json([
        'message' => 'User created successfully',
        'data' => $result,
    ], 201);
}
public  function login(Request $request)
{
    $validate=$request->validate([
        'email'=>['required'],
        'password'=>['required','string','min:8','max:255']
    ]);
   $result= User::where('email',$validate['email'])->first();
   if($result)
    {
       
        if(Hash::check($validate['password'],$result->password))
            {
                $token=$result->createToken('api-token')->plainTextToken;
                return response()->json([
                'message'=>'login successfully',
                 'token'=>$token,
                 'data'=>$result
                ]);

            }
            return response()->json([
                'message'=> 'incorrect credentian'
            ],404);

    }
     return response()->json([
                'message'=> 'incorrect credentian'
            ],404);

}
}
