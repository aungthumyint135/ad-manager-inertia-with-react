<?php

namespace App\Services\Publisher;

use App\Repositories\Publisher\PublisherRepositoryInterface;

class PublisherService
{
    public function __construct(
        protected PublisherRepositoryInterface $publisherRepository
    )
    {
        //
    }

    public function getAllPublishers()
    {
        return $this->publisherRepository->all();
    }
}
