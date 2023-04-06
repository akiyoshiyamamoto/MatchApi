<?php

namespace App\Http\Controllers;

use App\Domain\Swipe\Repositories\SwipeRepositoryInterface;
use App\Http\Requests\SwipeRightRequest;
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
        $swiperId = auth()->id();
        $swipedId = $request->input('swiped_id');

        $swipe = $this->swipeRepository->create($swiperId, $swipedId, true);

        return response()->json([
            'message' => 'Swipe right successful',
            'data' => [
                'id' => $swipe->getId(),
                'swiper_id' => $swipe->getSwiperId(),
                'swiped_id' => $swipe->getSwipedId(),
                'liked' => $swipe->isLiked(),
            ]
        ]);
    }
}
