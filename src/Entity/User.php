<?php

namespace HackbartPR\Entity;

class User
{
    private ?int $id;
    public readonly string $email;
    private readonly string $password;

    public function __construct(?int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;        
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function password(): string
    {
        return $this->password;
    }
}