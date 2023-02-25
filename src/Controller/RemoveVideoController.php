<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class RemoveVideoController implements Controller
{
    private Message $message;
    private PDOVideoRepository $repository;

    use Message;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function processRequest(): void
    {
        [$id] = $this->validation();
        $result = $this->repository->remove($id);

        if ($result) {
            $this->create(self::REMOVE_SUCCESS);
        } else {
            $this->create(self::REMOVE_FAIL);
        }
    }

    private function validation(): array
    {
        if (!isset($_GET['id'])) {
            $this->create(self::NOT_FOUND);
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);        
        return [$id];        
    }
}