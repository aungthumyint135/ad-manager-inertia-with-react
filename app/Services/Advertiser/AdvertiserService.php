<?php

namespace App\Services\Advertiser;

use App\Models\Advertiser\Advertiser;
use App\Repositories\Advertiser\AdvertiserRepositoryInterface;

class AdvertiserService
{
    public function __construct( protected AdvertiserRepositoryInterface $advertiserRepository)
    {
        //
    }

    public function getAllAdvertisers()
    {
        return $this->advertiserRepository->all();
    }
}
