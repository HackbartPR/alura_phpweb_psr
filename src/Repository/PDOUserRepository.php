<?php

namespace HackbartPR\Repository;

use PDO;
use HackbartPR\Entity\User;
use HackbartPR\Interfaces\UserRepository;

class PDOUserRepository implements UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if (!$user) {
            return null;
        }

        return new User($user['id'], $user['email'], $user['password']);
    }    
}