<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class NewVideoController implements Controller
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
        [$url, $title, $image_path] = $this->validation();

        if (!empty($image_path)) {
            $image_path = $this->image->getName();
        }

        $resp = $this->repository->save(new Video(null, $title, $url, $image_path));

        if ($resp) {
            $this->message::create($this->message::REGISTER_SUCCESS);
        } else {
            $this->message::create($this->message::REGISTER_FAIL);
        }
    }

    private function validation(): array
    {
        if (!isset($_POST)) {
            $this->message::create($this->message::FORM_FAIL);
        }

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

        if (!empty($image_path) && !$this->image->isValid($image_path)) {
            $this->message::create($this->message::IMAGE_NOT_SAVED, '/novo');
        }

        return [$url, $title, $image_path];        
    }
}