<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;

class NewVideoController implements Controller
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
        [$url, $title, $image_path] = $this->validation();

        if (!empty($image_path)) {
            $image_path = $this->getName();
        }

        $resp = $this->repository->save(new Video(null, $title, $url, $image_path));

        if ($resp) {
            $this->create(self::REGISTER_SUCCESS);
        } else {
            $this->create(self::REGISTER_FAIL);
        }
    }

    private function validation(): array
    {
        if (!isset($_POST)) {
            $this->create(self::FORM_FAIL);
        }

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

        if (!empty($image_path) && !$this->isValid($image_path)) {
            $this->create(self::IMAGE_NOT_SAVED, '/novo');
        }

        return [$url, $title, $image_path];        
    }
}