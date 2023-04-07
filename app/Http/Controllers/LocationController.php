<?php

namespace App\Http\Controllers;

use App\Domain\Location\Repositories\LocationRepositoryInterface;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    private LocationRepositoryInterface $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function update(UpdateLocationRequest $request): JsonResponse
    {
        try {
            $userId = auth()->id();
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $location = $this->locationRepository->createOrUpdate($userId, $latitude, $longitude);

            return response()->json([
                'message' => 'Location updated successfully',
                'data' => [
                    'id' => $location->getId(),
                    'user_id' => $location->getUserId(),
                    'latitude' => $location->getLatitude(),
                    'longitude' => $location->getLongitude(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
