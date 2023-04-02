<?php

namespace App\Domain\User\Services;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(string $name, string $email, string $password): User
    {
        $hashedPassword = Hash::make($password);
        return $this->userRepository->create($name, $email, $hashedPassword);
    }

    public function login(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null || !Hash::check($password, $user->getPassword())) {
            return null;
        }

        return $user;
    }

    public function logout(): bool
    {
        return $this->invalidateToken();
    }

    public function isEmailRegistered(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        return $user !== null;
    }

    public function invalidateToken()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            // トークン無効化に失敗した場合、エラーを処理する
            // ここでは、例外を投げるか、ログを出力するなどの処理を追加できます
            return false;
        }

        return true;
    }
}
