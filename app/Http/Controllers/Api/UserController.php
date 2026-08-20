<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:12'],
        ]);
        $check = User::where('email', $validated['email'])->exists();
        if ($check) {
            return response()->json([
                'message' => 'Email already exists',
                'success' => 'false',
            ], 422);
        }
        $result = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $result,
            'success' => 'true',
        ], 200);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:12'],
        ]);
        $result = User::where('email', $validate['email'])->first();
        if ($result) {
            if (Hash::check($validate['password'], $result->password)) {
                $token = $result->createToken('api-token')->plainTextToken;

                return response()->json([
                    'message' => 'login successfully',
                    'success' => 'true',
                    'token' => $token,
                    'data' => $result,
                ], 200);
            }

            return response()->json([
                'message' => 'incorrect credential',
                'success' => 'false',
            ], 404);
        }

        return response()->json([
            'message' => 'incorrect credential',
            'success' => 'false',
        ], 404);

    }
}
