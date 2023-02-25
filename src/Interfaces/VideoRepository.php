<?php

namespace HackbartPR\Interfaces;

use PDO;
use HackbartPR\Entity\Video;

interface VideoRepository
{
    public function __construct(PDO $pdo);

    public function save(Video $video):bool;

    public function add(Video $video): bool;
    
    public function update(Video $video):bool;

    public function remove(int $id): bool;

    public function all(): array;
}