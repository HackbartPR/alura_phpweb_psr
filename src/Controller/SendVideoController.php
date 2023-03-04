<?php

namespace HackbartPR\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use HackbartPR\Repository\PDOVideoRepository;

class SendVideoController implements RequestHandlerInterface
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
        [$id] = $this->validation($request);

        $video = null;
        if ($id) {
            $video = $this->repository->show($id);
        }

        $this->show();
        return new Response(200, body: $this->template->render('sendVideo', ['video' => $video]));        
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