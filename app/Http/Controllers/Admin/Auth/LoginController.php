<?php

namespace App\Http\Controllers\Admin\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\LoginService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\LoginRequest;

class LoginController extends Controller
{
    public function __construct(protected LoginService $loginService)
    {

    }
    public function create()
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        if ($this->loginService->login($request)) {
            // Redirect to the intended page or admin dashboard
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }
}
