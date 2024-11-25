<?php

use App\Http\Controllers\User\UserController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Agency\AgencyController;
use App\Http\Controllers\Publisher\PublisherController;
use App\Http\Controllers\Advertiser\AdvertiserController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::group(['middleware' => 'auth:web,admin', 'verified'], function () {
    Route::get('/dashboard', function (){
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('agencies', AgencyController::class)->names('agencies');

    Route::resource('users', UserController::class)->names('users');

});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/admanager.php';
