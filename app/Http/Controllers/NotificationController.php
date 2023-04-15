<?php

namespace App\Http\Controllers;

use App\Domain\User\Services\UserService;
use App\Http\Resources\NotificationResourceCollection;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getNewMatchNotifications(Request $request)
    {
        $userId = auth()->user()->id;
        $notifications = $this->userService->getNewMatchNotifications($userId);
        return new NotificationResourceCollection($notifications);
    }
}
