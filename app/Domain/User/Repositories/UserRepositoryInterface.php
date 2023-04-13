<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\ProfileImage;
use App\Domain\User\Entities\User;

interface UserRepositoryInterface
{
    public function create(string $name, string $email, string $password): User;
    public function findByEmail(string $email): ?User;
    public function update(User $user): bool;
    public function getUserById(int $userId): ?User;
    public function getProfileImages(int $userId): array;
    public function addProfileImage(int $userId, string $path): ProfileImage;
    public function removeProfileImage(int $id): bool;
    public function getProfileImagePathById(int $imageId): ?string;
    public function updateUserLocation(int $userId, float $latitude, float $longitude): bool;
    public function findNearbyUsers(float $latitude, float $longitude, float $radius): array;
    public function findMatchedUsers(int $userId): array;


}
