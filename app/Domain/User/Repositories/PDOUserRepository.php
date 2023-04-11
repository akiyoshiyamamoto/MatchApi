<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\ProfileImage;
use App\Domain\User\Entities\User;
use PDO;

class PDOUserRepository implements UserRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create(string $name, string $email, string $password): User
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)'
        );
        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
        ]);

        $id = (int)$this->connection->lastInsertId();

        return $this->findUserById($id);
    }

    public function findByEmail(string $email): ?User
    {
        $statement = $this->connection->prepare('SELECT * FROM users WHERE email = :email');
        $statement->execute([':email' => $email]);
        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        return $userData ? $this->createUserFromData($userData) : null;
    }

    public function update(User $user): bool
    {
        $statement = $this->connection->prepare(
            'UPDATE users SET name = :name, email = :email WHERE id = :id'
        );
        return $statement->execute([
            ':id' => $user->getId(),
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
        ]);
    }

    public function findUserById(int $id): User
    {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->createUserFromData($result);
    }

    public function getUserById(int $userId): ?User
    {
        $statement = $this->connection->prepare('SELECT * FROM users WHERE id = :id');
        $statement->execute([':id' => $userId]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->createUserFromData($result) : null;
    }

    public function updateProfileImage($userId, $path)
    {
        $stmt = $this->connection->prepare("INSERT INTO profile_images (user_id, image_path) VALUES (:userId, :path)");
        $stmt->execute(['userId' => $userId, 'path' => $path]);
    }

    public function removeProfileImage($userId): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM profile_images WHERE id = :imageId");
        return $stmt->execute(['userId' => $userId]);
    }

    private function createUserFromData(array $userData): User
    {
        return new User(
            (int)$userData['id'],
            $userData['name'],
            $userData['email'],
            $userData['password'],
            new \DateTime($userData['created_at']),
            new \DateTime($userData['updated_at']),
            $userData['latitude'],
            $userData['longitude'],
        );
    }

    public function getProfileImagePathById(int $imageId): ?string
    {
        $sql = "SELECT path FROM profile_images WHERE id = :imageId";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['path'] : null;
    }

    public function getProfileImages(int $userId): array
    {
        $sql = "SELECT * FROM profile_images WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $profileImages = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $profileImages[] = new ProfileImage($row['id'], $row['user_id'], $row['path']);
        }

        return $profileImages;
    }

    public function addProfileImage(int $userId, string $path): ProfileImage
    {
        $sql = "INSERT INTO profile_images (user_id, path) VALUES (:user_id, :path)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':path', $path, PDO::PARAM_STR);
        $stmt->execute();

        $id = $this->connection->lastInsertId();
        return new ProfileImage($id, $userId, $path);
    }

    public function updateUserLocation(int $userId, float $latitude, float $longitude): bool
    {
        $stmt = $this->connection->prepare("UPDATE users SET latitude = :latitude, longitude = :longitude WHERE id = :userId");
        return $stmt->execute(['latitude' => $latitude, 'longitude' => $longitude, 'userId' => $userId]);
    }

    public function findNearbyUsers(float $latitude, float $longitude, float $radius): array
    {
        $stmt = $this->connection->prepare("
    SELECT *,
           ( 6371 * acos( cos( radians(:latitude) )
                         * cos( radians( latitude ) )
                         * cos( radians( longitude ) - radians(:longitude) )
                         + sin( radians(:latitude) )
                         * sin( radians( latitude ) ) ) ) AS distance
    FROM users
    HAVING distance < :radius
    ORDER BY distance
");
        $stmt->execute(['latitude' => $latitude, 'longitude' => $longitude, 'radius' => $radius]);
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($usersData as $userData) {
            $users[] = $this->createUserFromData($userData);
        }

        return $users;
    }
}
