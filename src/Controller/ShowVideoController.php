<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use HackbartPR\Utils\HtmlView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use HackbartPR\Repository\PDOVideoRepository;
use Psr\Http\Server\RequestHandlerInterface;

class ShowVideoController implements RequestHandlerInterface
{   
    private PDOVideoRepository $repository;

    use Message;
    use HtmlView;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->show();
        return new Response(200, body:$this->renderTemplate('showVideo', ['videoList' => $this->repository->all()]));                
    }        
}