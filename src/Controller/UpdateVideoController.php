<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        $param = $request->getQueryParams();
        $url = '/editar?id=' . $param['id'];

        [$id, $url, $title, $image_path, $validation] = $this->validation($request);
        
        if (!$validation) {            
            return new Response(422, ['Location' => $url]);
        }

        if (!empty($image_path)) {
            $image_path = $this->getName();
        }

        $resp = $this->repository->save(new Video($id, $title, $url, $image_path));

        if ($resp) {
            $this->create(self::UPDATE_SUCCESS);
            return new Response(200, ['Location' => '/']);
        } else {
            $this->create(self::UPDATE_FAIL);
            return new Response(422, ['Location' => $url]);
        }
    }

    private function validation(ServerRequestInterface $request): array
    {   
        $body = $request->getParsedBody();
        $validation = true;

        if (empty($body) || !isset($body['id'])) {
            $this->create(self::FORM_FAIL);
            $validation = false;
        }

        $id = filter_var($body['id'], FILTER_VALIDATE_INT);
        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        $title = filter_var($body['titulo']);
        
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) {
            $image_path = $_FILES['image'];
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
            $this->create(self::IMAGE_NOT_SAVED);
            $validation = false;
        }

        return [$id, $url, $title, $image_path. $validation];        
    }
}