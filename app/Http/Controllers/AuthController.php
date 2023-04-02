<?php

namespace App\Http\Controllers;

use App\Domain\User\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ErrorResponseResource;
use App\Http\Resources\LoginResponseResource;
use App\Http\Resources\LogoutResponseResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        if ($this->authService->isEmailRegistered($request->input('email'))) {
            return new ErrorResponseResource([
                'message' => 'Email is already registered.',
            ], 400);
        }

        $user = $this->authService->register(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {

        $user = $this->authService->login(
            $request->input('email'),
            $request->input('password')
        );

        if ($user === null) {
            return new ErrorResponseResource([
                'message' => 'Email is already registered.',
            ], 400);
        }

        $token = JWTAuth::fromUser($user);
        return new LoginResponseResource(['access_token' => $token]);
    }

    public function logout()
    {
        $this->authService->logout();
        return new LogoutResponseResource(['message' => 'Logged out successfully.']);
    }
}
