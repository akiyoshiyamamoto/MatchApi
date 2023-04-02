<?php

namespace App\Domain\User\Repositories;

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

    private function findUserById(int $id): User
    {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->createUserFromData($result);
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
        );
    }
}
