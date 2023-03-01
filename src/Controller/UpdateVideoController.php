<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Image;
use HackbartPR\Entity\Video;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UploadedFileInterface;
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
        $query = $request->getQueryParams();        
        $files = $request->getUploadedFiles();
        $validation = true;

        if (empty($body) || !isset($query['id'])) {
            $this->create(self::FORM_FAIL);
            $validation = false;
        }

        $id = filter_var($query['id'], FILTER_VALIDATE_INT);
        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        $title = filter_var($body['titulo']);
        
        /** @var UploadedFileInterface $image */
        $image = $files['image']->getSize() ? $files['image'] : null;        

        if (!is_null($image) && $image->getError() !== UPLOAD_ERR_OK) {            
            $validation = false;
        } 
        
        if (!$url) {
            $this->create(self::URL_FAIL);
            $validation = false;
        }
        
        if (!$title) {
            $this->create(self::TITLE_FAIL);
            $validation = false;
        }

        if (!empty($image) && !$this->isValid($image)) {
            $this->create(self::IMAGE_NOT_SAVED);
            $validation = false;
        }

        return [$id, $url, $title, $image, $validation];        
    }
}