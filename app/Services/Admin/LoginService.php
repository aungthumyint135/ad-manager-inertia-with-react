<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class LoginService
{

        public function login($request): bool
        {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return true;
            }

            return false;
        }
}
