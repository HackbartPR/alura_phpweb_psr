<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use HackbartPR\Utils\HtmlView;
use HackbartPR\Interfaces\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use HackbartPR\Repository\PDOVideoRepository;

class ShowVideoController implements Controller
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
        $this->show();
        return new Response(302, body: $this->renderTemplate('showVideo', ['videoList' => $this->repository->all()]));                
    }        
}