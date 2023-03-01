<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use HackbartPR\Utils\HtmlView;
use HackbartPR\Interfaces\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        [$id] = $this->validation($request);

        $video = null;
        if ($id) {
            $video = $this->repository->show($id);
        }

        $this->show();
        return new Response(200, body: $this->renderTemplate('sendVideo', ['video' => $video]));        
    }

    private function validation(ServerRequestInterface $request): array
    {
        $query = $request->getQueryParams();        

        $id = null;
        if (isset($query['id'])) {
            $id = filter_var($query['id'], FILTER_VALIDATE_INT);            
        }

        return [$id];        
    }
}