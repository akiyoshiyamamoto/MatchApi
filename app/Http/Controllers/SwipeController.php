<?php

namespace App\Http\Controllers;

use App\Domain\Swipe\Repositories\SwipeRepositoryInterface;
use App\Http\Requests\SwipeLeftRequest;
use App\Http\Requests\SwipeRightRequest;
use App\Http\Resources\SwipeResource;
use Illuminate\Http\JsonResponse;

class SwipeController extends Controller
{
    private SwipeRepositoryInterface $swipeRepository;

    public function __construct(SwipeRepositoryInterface $swipeRepository)
    {
        $this->swipeRepository = $swipeRepository;
    }

    public function rightSwipe(SwipeRightRequest $request): JsonResponse
    {
        try {
            $swiperId = auth()->id();
            $swipedId = $request->input('swiped_id');

            $swipe = $this->swipeRepository->create($swiperId, $swipedId, true);

            return (new SwipeResource($swipe))
                ->response()
                ->setStatusCode(200)
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function leftSwipe(SwipeLeftRequest $request): JsonResponse
    {
        try {
            $swiperId = auth()->id();
            $swipedId = $request->input('swiped_id');

            $swipe = $this->swipeRepository->create($swiperId, $swipedId, false);

            return (new SwipeResource($swipe))
                ->response()
                ->setStatusCode(200)
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
