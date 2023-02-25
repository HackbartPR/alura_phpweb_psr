<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class UpdateVideoController implements Controller
{
    private Image $image;
    private Message $message;
    private PDOVideoRepository $repository;

    public function __construct(PDOVideoRepository $repository ,Message $message, Image $image)
    {
        $this->repository = $repository;
        $this->message = $message;
        $this->image = $image;
    }

    public function processRequest(): void
    {
        [$id, $url, $title, $image_path] = $this->validation();

        if (!empty($image_path)) {
            $image_path = $this->image->getName();
        }

        $resp = $this->repository->save(new Video($id, $title, $url, $image_path));

        if ($resp) {
            Message::create(Message::UPDATE_SUCCESS);
        } else {
            Message::create(Message::UPDATE_FAIL);
        }
    }

    private function validation(): array
    {
        if (!isset($_POST) || !isset($_GET['id'])) {
            $this->message::create($this->message::FORM_FAIL);
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, 'titulo');
        
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) {
            $image_path = $_FILES['image'];
        }
        
        if (!$url) {
            $this->message::create($this->message::URL_FAIL);
        }
        
        if (!$title) {
            $this->message::create($this->message::TITLE_FAIL);
        }

        $this->getUrlParams();

        if (!empty($image_path) && !$this->image->isValid($image_path)) {
            $this->message::create($this->message::IMAGE_NOT_SAVED, $this->getUrlParams());
        }

        return [$id, $url, $title, $image_path];        
    }

    private function getUrlParams(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}