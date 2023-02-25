<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class RemoveVideoController implements Controller
{
    private Message $message;
    private PDOVideoRepository $repository;

    public function __construct(PDOVideoRepository $repository, Message $message)
    {
        $this->repository = $repository;
        $this->message = $message;
    }

    public function processRequest(): void
    {
        [$id] = $this->validation();
        $result = $this->repository->remove($id);

        if ($result) {
            $this->message::create($this->message::REMOVE_SUCCESS);
        } else {
            $this->message::create($this->message::REMOVE_FAIL);
        }
    }

    private function validation(): array
    {
        if (!isset($_GET['id'])) {
            $this->message::create($this->message::NOT_FOUND);
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);        
        return [$id];        
    }
}