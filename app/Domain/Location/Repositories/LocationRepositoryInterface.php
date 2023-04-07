<?php

namespace App\Domain\Location\Repositories;

use App\Domain\Location\Entities\Location;

interface LocationRepositoryInterface
{
    public function createOrUpdate(int $userId, float $latitude, float $longitude): Location;
}
