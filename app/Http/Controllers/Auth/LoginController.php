<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect user after login.
     */
   public function redirectTo()
{
    $user = auth()->user();

    if ($user->hasAnyRole(['company_user', 'super_admin'])) {
        return route('home');
    }

    return route('home');
}

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}