<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class UpdateVideoController implements Controller
{    
    private PDOVideoRepository $repository;

    use Image;
    use Message;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;        
    }

    public function processRequest(): void
    {
        [$id, $url, $title, $image_path] = $this->validation();

        if (!empty($image_path)) {
            $image_path = $this->getName();
        }

        $resp = $this->repository->save(new Video($id, $title, $url, $image_path));

        if ($resp) {
            $this->create(self::UPDATE_SUCCESS);
        } else {
            $this->create(self::UPDATE_FAIL);
        }
    }

    private function validation(): array
    {
        if (!isset($_POST) || !isset($_GET['id'])) {
            $this->create(self::FORM_FAIL);
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, 'titulo');
        
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) {
            $image_path = $_FILES['image'];
        }
        
        if (!$url) {
            $this->create(self::URL_FAIL);
        }
        
        if (!$title) {
            $this->create(self::TITLE_FAIL);
        }

        $this->getUrlParams();

        if (!empty($image_path) && !$this->isValid($image_path)) {
            $this->create(self::IMAGE_NOT_SAVED, $this->getUrlParams());
        }

        return [$id, $url, $title, $image_path];        
    }

    private function getUrlParams(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}