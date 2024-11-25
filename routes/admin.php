<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;



Route::prefix('admin')->name('admin.')->group(function () {

   Route::middleware(['guest:admin'])->group(function () {
    Route::get('/login',[LoginController::class,'create'])->name('login');

    Route::post('/login',[LoginController::class,'store'])->name('login');
   });

    Route::middleware('auth:admin')->group(function(){
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');
    });

});


Route::get('/check-auth', function () {
    return response()->json(['admin' => Auth::guard('admin')->check()]);
});


Route::get('/debug-session', function (Request $request) {
    return response()->json([
        'auth_admin' => Auth::guard('web')->check(),
        'session' => session()->all(),
    ]);
});
