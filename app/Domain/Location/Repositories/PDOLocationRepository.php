<?php

namespace App\Domain\Location\Repositories;

use App\Domain\Location\Entities\Location;
use Illuminate\Database\ConnectionInterface;

class PDOLocationRepository implements LocationRepositoryInterface
{
    private ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function createOrUpdate(int $userId, float $latitude, float $longitude): Location
    {
        $existingLocation = $this->connection
            ->table('locations')
            ->where('user_id', $userId)
            ->first();

        if ($existingLocation) {
            $this->connection
                ->table('locations')
                ->where('user_id', $userId)
                ->update([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);

            return new Location(
                $existingLocation->id,
                $userId,
                $latitude,
                $longitude
            );
        }

        $locationId = $this->connection
            ->table('locations')
            ->insertGetId([
                'user_id' => $userId,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

        return new Location(
            $locationId,
            $userId,
            $latitude,
            $longitude
        );
    }
}
