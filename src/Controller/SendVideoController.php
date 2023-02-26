<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Message;
use HackbartPR\Utils\HtmlView;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class SendVideoController implements Controller
{
    private PDOVideoRepository $repository;

    use Message;
    use HtmlView;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;        
    }

    public function processRequest(): void
    {
        [$id] = $this->validation();

        $video = null;
        if ($id) {
            $video = $this->repository->show($id);
        }

        echo $this->renderTemplate('sendVideo', ['video' => $video]);        
        $this->show();
    }

    private function validation(): array
    {
        $id = null;
        if (isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);            
        }

        return [$id];        
    }
}