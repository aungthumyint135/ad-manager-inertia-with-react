<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admanager\AdmanagerController;

Route::get('get-all-users',[AdmanagerController::class,'getAllUsers']);
Route::get('get-all-sites',[AdmanagerController::class,'getAllSites']);
Route::get('agency-report',[AdmanagerController::class,'agencyReport']);
Route::get('publisher-report',[AdmanagerController::class,'publisherReport']);
Route::get('advertiser-report',[AdmanagerController::class,'advertiserReport']);
