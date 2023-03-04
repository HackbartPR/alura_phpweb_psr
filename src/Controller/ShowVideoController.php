<?php

namespace HackbartPR\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use HackbartPR\Repository\PDOVideoRepository;
use Psr\Http\Server\RequestHandlerInterface;

class ShowVideoController implements RequestHandlerInterface
{   
    private PDOVideoRepository $repository;
    private Engine $template;

    use Message;

    public function __construct(PDOVideoRepository $repository, Engine $template)
    {
        $this->repository = $repository;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->show();
        return new Response(200, body:$this->template->render('showVideo', ['videoList' => $this->repository->all()]));                
    }        
}