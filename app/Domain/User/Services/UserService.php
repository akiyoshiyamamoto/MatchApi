<?php

namespace App\Domain\User\Services;

use App\Domain\Notification\Repositories\NotificationRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotificationRepositoryInterface $notificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
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

    public function updateUserLocation($userId, $latitude, $longitude): void
    {
        $this->userRepository->updateUserLocation($userId, $latitude, $longitude);
    }

    public function findNearbyUsers($latitude, $longitude, $radius): array
    {
        if ($longitude === null || $latitude === null || $radius === null) {
            return [];
        }
        return $this->userRepository->findNearbyUsers($latitude, $longitude, $radius);
    }

    public function findMatchedUsers(int $userId): array
    {
        return $this->userRepository->findMatchedUsers($userId);
    }

    public function getNewMatchNotifications(int $userId): array
    {
        return $this->notificationRepository->findNewMatchNotifications($userId);
    }

    public function getProfileImages(int $userId): array
    {
        return $this->userRepository->getProfileImages($userId);
    }

    public function addProfileImage(int $userId, string $path): \App\Domain\User\Entities\ProfileImage
    {
        return $this->userRepository->addProfileImage($userId, $path);
    }

    public function getProfileImagePathById(int $profileImageId): string
    {
        return $this->userRepository->getProfileImagePathById($profileImageId);
    }

    public function removeProfileImage(int $profileImageId): void
    {
        $this->userRepository->removeProfileImage($profileImageId);
    }
}
