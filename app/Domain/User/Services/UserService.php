<?php

namespace App\Domain\User\Services;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function update(User $user, array $data): User
    {
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        $this->userRepository->update($user);

        return $user;
    }

    public function findUserById(int $id): User
    {
        return $this->userRepository->findUserById($id);
    }
}
