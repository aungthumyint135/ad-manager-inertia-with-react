<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Services\Agency\AgencyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgencyController extends Controller
{

    public function __construct(
        protected AgencyService $agencyService
    )
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $agencies = $this->agencyService->getAllAgencies();
        return Inertia::render('Agency/Index', ['agencies' => $agencies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Agency/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $this->agencyService->createAgency($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
