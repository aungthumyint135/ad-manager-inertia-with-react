<?php

namespace App\Services\Agency;
use App\Repositories\Agency\AgencyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgencyService
{
    public function __construct(
        protected AgencyRepositoryInterface $agencyRepository
    )
    {
        //
    }

    public function getAllAgencies()
    {
        return $this->agencyRepository->all();
    }

    public function createAgency($data)
    {
        return $this->agencyRepository->insert($data);
    }

    public function updateAgency(Request $request, $uuid)
    {

    }

    public function getAgencyByUuid($uuid)
    {

    }

    public function getAgencyById($id)
    {

    }

    public function deleteAgency($uuid)
    {

    }
}
