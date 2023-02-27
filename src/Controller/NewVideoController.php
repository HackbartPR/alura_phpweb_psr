<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewVideoController implements Controller
{    
    private PDOVideoRepository $repository;

    use Image;
    use Message;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;                
    }

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        [$url, $title, $image_path, $validation] = $this->validation($request);

        if (!$validation) {
            return new Response(422, ['Location' => '/novo']);
        }

        if (!empty($image_path)) {
            $image_path = $this->getName();
        }

        $resp = $this->repository->save(new Video(null, $title, $url, $image_path));

        if ($resp) {
            $this->create(self::REGISTER_SUCCESS);
            return new Response(201, ['Location' => '/']);
        } else {
            $this->create(self::REGISTER_FAIL);
            return new Response(422, ['Location' => '/novo']);
        }
    }

    private function validation(ServerRequestInterface $request): ?array
    {
        $body = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $validation = true;

        if (empty($body)) {
            $this->create(self::FORM_FAIL);
        }

        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        $title = filter_input($body['title'], FILTER_DEFAULT);
        
        
        $image_path = null;
        if (isset($files['image']) && $files['image']['error'] !== 4) {
            $image_path = $files['image'];
        }         

        if (!$url) {
            $this->create(self::URL_FAIL);
            $validation = false;
        }
        
        if (!$title) {
            $this->create(self::TITLE_FAIL);
            $validation = false;
        }

        if (!empty($image_path) && !$this->isValid($image_path)) {
            $this->create(self::IMAGE_NOT_SAVED, '/novo');
            $validation = false;
        }

        return [$url, $title, $image_path, $validation];        
    }
}