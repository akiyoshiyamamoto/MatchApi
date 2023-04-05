<?php

namespace App\Http\Controllers;

use App\Domain\User\Services\UserService;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(Request $request)
    {
        $user = $this->userService->findUserById(auth()->user()->id);

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->findUserById(auth()->user()->id);
        $updatedUser = $this->userService->update($user, $request->validated());

        return (new UserResource($user))->response()->setStatusCode(200);
    }
}
