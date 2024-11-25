<?php

namespace App\Http\Controllers\Admanager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admanager\AdmanagerService;

class AdmanagerController extends Controller
{
    public function __construct(protected AdmanagerService $admanagerService)
    {
       //
    }

    public function getAllUsers()
    {
        return $this->admanagerService->getAllUsers();
    }

    public function getAllSites()
    {
        return $this->admanagerService->getAllSites();
    }

    public function agencyReport()
    {
        return $this->admanagerService->agencyReport();
    }

    public function publisherReport()
    {
        return $this->admanagerService->publisherReport();
    }

    public function advertiserReport()
    {
        return $this->admanagerService->advertiserReport();
    }
}
