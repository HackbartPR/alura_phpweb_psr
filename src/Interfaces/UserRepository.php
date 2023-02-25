<?php

namespace HackbartPR\Interfaces;

use PDO;
use HackbartPR\Entity\User;

interface UserRepository
{
    public function __construct(PDO $pdo);

    public function findByEmail(string $email): ?User;    
}